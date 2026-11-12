<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
            'publicado_em' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublicadas(Builder $query): Builder
    {
        return $query->where('publicado', true)->orderByDesc('publicado_em')->orderByDesc('legacy_id');
    }

    public function url(): string
    {
        return route('noticias.show', $this);
    }
}
