<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topico;
use Illuminate\Http\Request;

class TopicoController extends Controller
{

    function get(){

    $topicos = Topico::get();

    return ['topicos' => $topicos];

    }

    function create(Request $request){

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:600'],
            'img' => ['string', 'max:100']
        ]);

        Topico::create([
            'nome' => $validated['nome'],
            'img' => $validated['img'] ?? null
        ]);

        return ['boa' => 'boa man'];
    }

    function delete(Request $request){

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:600'],
        ]);

        $topic = Topico::where('name', $validated['nome'])->first();

        $count = $topic->delete();

        return ['count' => $count];
    }
}
