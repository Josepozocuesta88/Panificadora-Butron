<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;
    protected $table = 'favoritos';
    
    public $timestamps = false;

    protected $fillable = [
        'favartcod',
        'favusucod'
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'favusucod','usuclicod');
    }
    
    public function producto() {
        return $this->belongsTo(Producto::class, 'favartcod','usuclicod');
    }
}
