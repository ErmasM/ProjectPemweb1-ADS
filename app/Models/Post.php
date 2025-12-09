<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    // Izin isi semua kolom (biar gak kena Mass Assignment Error)
    protected $guarded = []; 

    // Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}