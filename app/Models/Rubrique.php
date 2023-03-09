<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrique extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'image',
        'ordre',
        'resto_id'
    ];
}
