<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubrique extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'image',
        'ordre',
        'resto_id'
    ];

    public function articles(): HasMany
    {
        return  $this->hasMany(Article::class);
    }
}
