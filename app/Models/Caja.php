<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'qanet_caja';
    protected $primaryKey = 'cajcod';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cajartcod',
        'cajcod',
        'cajnom',
        'cajreldir', //caja relacion directa (unidades que lleva la caja)
        'cajbarcod',
        'cajdef', // caja por defecto
        'cajtip',
        'cajvol',
    ];

    // public function articulos()
    // {
    //     return $this->belongsToMany(Articulo::class, 'etitagcod', 'barcod');
    // }

    public static function quantityByType($artcod, $type, $quantity)
    {
        if ($type === '0001' || $type === '0002') { 
            $caja = Caja::where('cajcod', $type)->where('cajartcod', $artcod)->firstOrFail();
            $quantity_box = $quantity;
            $quantity_ud = $quantity_box * $caja->cajreldir;
        }
        else{
            $quantity_box = $quantity;
            $quantity_ud = $quantity;
            // \Log::info('Artículo no encontrado', ['quantity_ud' => $quantity_ud]); 
            // \Log::info('Artículo no encontrado', ['quantity_box' => $quantity_box]); 
            // \Log::info('Artículo no encontrado', ['quantity' => $quantity]); 
        }

        return [$quantity_ud, $quantity_box]; 

    }
}