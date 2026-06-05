<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('apelido')->unique();;
            $table->string('email')->unique();;
            $table->string('senha');
            $table->string('nome');
            $table->rememberToken()->nullable();
            $table->timestamps();
        });

        Schema::create('topicos', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('nome')->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('corpo');
            $table->foreignId('topico_id')->constrained(
                    table: 'topicos', indexName: 'posts_topico_id'
                    )->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('comentario');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('topicos');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('comentarios');
    }
};