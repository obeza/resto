<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('prenom');
            $table->string('nom');
            $table->string('prefixe');
            $table->string('tel');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('tel_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('actif', ['oui','non'])->default('non');
            $table->uuid('user_creat')->index();
            $table->tinyInteger('role')->default(0);
            /* Users: 0=>User, 1=>Admin, 2=>SuperAdmin */
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
