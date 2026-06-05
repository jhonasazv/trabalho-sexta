<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{   

    function create(Request $request, string $id){

        $validated = $request->validate([
            'comentario' => ['required', 'max:600'],
        ]);

        $user = Auth::user();

        $post = Post::find($id);

        $comentario = new Comentario([
            'comentario' => $validated['comentario']
        ]);

        $comentario->user()->associate($user);
        $comentario->post()->associate($post);

        $comentario->save();

        return ['redirect' => '/post/' . $post->id];
    }

    function delete(Request $request, string $id){

        $comentario = Comentario::find($id);

        $post = $comentario->post;

        $comentario->delete();

        return ['redirect' => '/post/' . $post->id];
    }
}
