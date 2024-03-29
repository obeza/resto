<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tags')->insert([
            [
                'titre' => 'Cuisson',
                'contenu' => 'Possibilité de choisir le type de cuisson.',
            ],
            [
                'titre' => 'Sauce',
                'contenu' => 'Possibilité de choisir la sauce.',
            ]
            
       ]);
    }
}
