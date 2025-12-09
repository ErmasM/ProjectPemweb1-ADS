<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    // Izinkan kolom ini diisi
    protected $fillable = ['post_id', 'name', 'body'];

    // Relasi balik ke Post (Optional tapi bagus)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}