<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

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

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'cartcajcod', 'cajcod');
    }
    


    public static function updateOrAddItem($artcod, $type, $quantity_ud, $quantity_box)
    {
        $user = Auth::user();
        $cartItem = self::where('cartusucod', $user->id)
            ->where('cartartcod', $artcod)
            ->where('cartcajcod', $type)
            ->first();

        if ($cartItem) {
            $cartItem->increment('cartcant', $quantity_ud);
            $cartItem->increment('cartcantcaj', $quantity_box);
        } else {
            self::create([
                'cartusucod' => $user->id,
                'cartartcod' => $artcod,
                'cartcant' => $quantity_ud,
                'cartcantcaj' => $quantity_box,
                'cartcajcod' => $type,
            ]);
        }
    }
    
}
