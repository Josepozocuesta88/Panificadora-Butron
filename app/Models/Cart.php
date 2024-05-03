<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'cartcod';

    protected $fillable = ['cartusucod',  'cartartcod', 'cartcant', 'cartcantcaj',  'cartcajcod'];


    public function user()
    {
        return $this->belongsTo(User::class, 'cartusucod', 'id');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'cartartcod', 'artcod');
    }
}
