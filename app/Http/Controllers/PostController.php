<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    function get(Request $request, string $id){


        // $post = Post::find($id);
        
        // $comentarios = $post->comentarios;

        $post = Post::with(['user', 'comentarios.user'])->find($id);

        /* $user = $post->user->is(Auth::user()) ? true : false; */

        return ['post' => $post, /*'comentarios' => $comentarios, 'posse' => $user*/];
    }

    function posts(Request $request, string $nome){


        //$topico = Topico::where('nome', $nome)->first();

        $topico = Topico::with('posts.user')->where('nome', $nome)->first();

        return ['posts' => $topico];
    }

    function create(Request $request, string $nome){

        $validated = $request->validate([
        'titulo' => ['required', 'max:400'],
        'corpo' => ['required', 'max:1500'],
        ]);

        $user = Auth::user();

        $topico = Topico::where('nome', $nome)->first();

        $post = new Post([
            'titulo' => $validated['titulo'],
            'corpo' => $validated['corpo']
        ]);

        $post->user()->associate($user);
        $post->topico()->associate($topico);

        $post->save();

        return ['redirect' => '/post/' . $post->id];
    }

    function delete(Request $request, string $id){

        dd($id);
        $post = Post::find($id);

        $topic = $post->topic->nome;

        $post->delete();

        return ['redirect' => '/topic/' . $topic];
    }
}
