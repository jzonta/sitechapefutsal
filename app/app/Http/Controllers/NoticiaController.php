<?php

namespace App\Http\Controllers;

use App\Models\Noticia;

class NoticiaController extends Controller
{
    public function index()
    {
        return view('noticias.index', ['noticias' => Noticia::publicadas()->get()]);
    }

    public function show(Noticia $noticia)
    {
        abort_unless($noticia->publicado, 404);

        $relacionadas = Noticia::publicadas()->where('id', '!=', $noticia->id)->take(2)->get();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }

    /** Redireciona URLs antigas (noticiaXX.html) para a nova rota, preservando SEO. */
    public function legado(int $id)
    {
        $noticia = Noticia::where('legacy_id', $id)->firstOrFail();

        return redirect()->route('noticias.show', $noticia, 301);
    }
}
