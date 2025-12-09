<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Kolom ID
            
            // === INI YANG HILANG TADI ===
            $table->unsignedBigInteger('post_id'); 
            // ============================

            $table->string('name');
            $table->text('body');
            $table->timestamps();

            // Relasi (Opsional tapi bagus): Kalau post dihapus, komen ikut hilang
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}