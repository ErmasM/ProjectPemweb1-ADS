<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Peminjam
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Buku
            $table->date('borrow_date'); // Tgl Pinjam
            $table->date('return_date')->nullable(); // Tgl Kembali (Diisi admin nanti)
            $table->string('status')->default('pending'); // pending, approved, rejected, returned
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};