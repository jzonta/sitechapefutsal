<?php

namespace App\Http\Controllers;

use App\Models\Noticia;

class PaginaController extends Controller
{
    public function home()
    {
        $ultimas = Noticia::publicadas()->take(6)->get();

        return view('pages.home', [
            'destaque' => $ultimas->first(),
            'ultimas' => $ultimas,
        ]);
    }

    public function historia() { return view('pages.historia'); }
    public function elenco() { return view('pages.elenco'); }
    public function competicoes() { return view('pages.competicoes'); }
    public function transparencia() { return view('pages.transparencia'); }
}
