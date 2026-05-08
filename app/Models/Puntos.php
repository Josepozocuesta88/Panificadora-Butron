<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntos extends Model
{
    use HasFactory;
    protected $table = 'gift_points';
    
    protected $fillable = [
        'codigo', 
        'euros',
        'puntos'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_gif_points', 'id', 'user_id');
    }
}
