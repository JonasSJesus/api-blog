<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Blog::all();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Nenhum artigo encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Artigos encontrados',
            'dados' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:30',
            'author' => 'required|email',
            'content' => 'required',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Dados inválidos',
                'erros' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $blog = new Blog();
        $blog->title = $validatedData['title'];
        $blog->author = $validatedData['author'];
        $blog->content = $validatedData['content'];
        $blog->category = $validatedData['category'];

        $blog->save();

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Post criado com sucesso',
            'dados' => $blog
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $article = Blog::findOrFail($id);

            return response()->json([
                'status' => 'sucesso',
                'mensagem' => 'Artigos encontrados',
                'dados' => $article
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Nenhum artigo encontrado',
                'dados' => $e->getMessage()
            ], 404);
        }
    }

    public function showByCategory(string $category)
    {
        $articles = Blog::where('category', $category)->get();

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Nenhum artigo encontrado para esta categoria',
                'dados' => []
            ], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Artigos encontrados',
            'total' => $articles->count(),
            'dados' => $articles
        ], 200);
    }

    public function showByTitle(string $title)
    {
        $articles = Blog::where('title', $title)->get();

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Nenhum artigo encontrado para este titulo',
                'dados' => []
            ], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Artigos encontrados',
            'total' => $articles->count(),
            'dados' => $articles
        ], 200);
    }

    public function showByAuthor(string $author)
    {
        $articles = Blog::where('author', $author)->get();

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Nenhum artigo encontrado para este autor',
                'dados' => []
            ], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Artigos encontrados',
            'total' => $articles->count(),
            'dados' => $articles
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:30',
            'author' => 'required|email',
            'content' => 'required',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Dados inválidos',
                'erros' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $article = Blog::findOrFail($id);

        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->category = $validatedData['category'];

        $article->save();

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Post atualizado com sucesso',
            'dados' => $article
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Blog::find($id);

        $article->delete();

        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Post deletado com sucesso',
        ], 204);
    }
}
