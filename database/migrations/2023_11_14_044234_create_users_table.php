<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->string('NUE')->unique();
            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id')->on('agremiados');
            $table->foreign('NUE')->references('NUE')->on('agremiados')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        try {
            // Tu código para insertar en la tabla 'agremiados'
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                // Duplicado en la restricción única
                // Puedes proporcionar un mensaje de error más informativo o realizar acciones específicas aquí
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
