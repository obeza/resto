<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rubrique;

class Resto extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'nom',
        'user_creat',
        'actif',
        'dt_abon',
        'tel',
        'adresse',
        'email',
        'commentaire'
    ];

    public function rubriques()
    {
        return $this->hasMany(Rubrique::class ,'resto_id');
    }
}
