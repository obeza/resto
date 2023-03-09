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
        Schema::create('restos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->uuid('user_creat');            
            $table->boolean('actif')->default(false);
            $table->date('dt_abon')->nullable();
            $table->string('tel')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('commentaire')->nullable();
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
        Schema::dropIfExists('restos');
    }
};
