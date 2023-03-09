<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $dt = Carbon::now();
        $user_id = Str::uuid()->toString();

        // ajoute le premier User, le superAdmin

        DB::table('users')->insert([
             'id' => $user_id,
             'prenom' => 'Olivier',
             'nom' => 'Bez',
             'prefixe' => '+596696',
             'tel' => '0696731820',
             'email' => 'o.bezaudin@gmail.com',
             'email_verified_at' => $dt,
             'password' => Hash::make('password'),
             'actif' => 'oui',
             'role' => 2,
             'user_creat' => $user_id,
             'is_email_verified' => 1,
             'created_at' => $dt,
             'updated_at' => $dt
        ]);
        

    }
}
