<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Tambahkan ini
use App\Models\Post; // Tambahkan ini

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'borrow_date',
        'return_date',
        'status', 
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Post (Buku)
    public function book()
    {
        // Pastikan foreign key-nya 'post_id'
        return $this->belongsTo(Post::class, 'post_id');
    }
}