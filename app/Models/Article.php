<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    //protected $table = 'articles';

    protected $fillable = [
        'user_id',
        'rubrique_id',
        'titre',
        'resume',
        'contenu',
        'prix',
        'ordre',
        'picture'
    ];

    public function tags(){
        return $this->belongsToMany(Tag::class)->as('tags');
    }

    public function rubrique(){
        return $this->belongsTo(Rubrique::class);
    }

}
