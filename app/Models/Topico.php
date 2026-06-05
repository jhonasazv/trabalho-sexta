<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'img'])]
#[Table('topicos')]
class Topico extends Model
{
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
