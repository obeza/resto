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
                'contenu' => 'Possibilit√© de choisir le type de cuisson.',
            ],
            [
                'titre' => 'Sauce',
                'contenu' => 'Possibilit√© de choisir la sauce.',
            ]
            
       ]);
    }
}
