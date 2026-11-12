<?php

use App\Http\Controllers\ContatoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PaginaController::class, 'home'])->name('home');
Route::get('/o-clube', [PaginaController::class, 'historia'])->name('historia');
Route::get('/elenco', [PaginaController::class, 'elenco'])->name('elenco');
Route::get('/competicoes', [PaginaController::class, 'competicoes'])->name('competicoes');
Route::get('/transparencia', [PaginaController::class, 'transparencia'])->name('transparencia');

Route::get('/contato', [ContatoController::class, 'create'])->name('contato');
Route::post('/contato', [ContatoController::class, 'store'])->middleware('throttle:5,1')->name('contato.store');

Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');

// URLs antigas do site estático
Route::get('/noticia{id}.html', [NoticiaController::class, 'legado'])->whereNumber('id');
Route::redirect('/index.html', '/', 301);
Route::redirect('/noticias.html', '/noticias', 301);
Route::redirect('/historia.html', '/o-clube', 301);
Route::redirect('/elenco.html', '/elenco', 301);
Route::redirect('/competicoes.html', '/competicoes', 301);
Route::redirect('/transparencia.html', '/transparencia', 301);
Route::redirect('/contato.html', '/contato', 301);
