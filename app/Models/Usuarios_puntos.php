<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios_puntos extends Model
{
    use HasFactory;
    protected $table = 'users_gif_points';
    
    protected $fillable = [
        'gif_point_id', 
        'user_id',
        'fecha_validez'
    ];
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function punto()
    {
        return $this->belongsTo(Puntos::class, 'gif_point_id'); 
    }
}
