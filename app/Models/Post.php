<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['titulo', 'corpo'])]
class Post extends Model
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topico(): BelongsTo
    {
        return $this->belongsTo(Topico::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

}
