<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $table = 'qanet_articulo';
    protected $primaryKey = 'artcod';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'artcod',
        'promedcod',
        'artnom',
        'artobs',  
        'artivacod',
        'artcatcod', 
        'artsit',
        'artbarcod', 
        'artdocaso', 
        'artstock',
        'artstocon',
        'artcatcodw1',
        'artsolcli'
    ];

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'qarticulo_etiqueta', 'etiartcod', 'etitagcod');
    }

    public function imagenes()
    {
        return $this->hasMany(Articulo_imagen::class, 'imaartcod', 'artcod')->where('imatip', 0);
    }

    public function primeraImagenRelacion()
    {
        return $this->imagenes()->where('imatip', 0)->orderBy('imaartcod', 'asc')->first();
    }
    
    public function pdf()
    {
        return $this->hasMany(Articulo_imagen::class, 'imaartcod', 'artcod')->where('imatip', 1);
    }

    public function alergenos()
    {
        return $this->belongsToMany(Etiqueta::class, 'qarticulo_etiqueta', 'etiartcod', 'etitagcod')
                    ->where('tagtip', 1);
    }

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'artcatcodw1', 'id');
        // return $this->belongsTo(Category::class, 'artcatcod3', 'id');
    }

    public function cajas()
    {
        return $this->hasMany(Caja::class, 'cajartcod', 'artcod');
    }

    public function favoritos() {
        return $this->hasMany(Favorito::class, 'favartcod', 'artcod');
    }
    public function historicos()
    {
        return $this->hasMany(Historico::class, 'estartcod', 'artcod');
    }

    public function primeraImagen()
    {
        $imagen = $this->imagenes()->first();
        return $imagen ? $imagen->imanom : null;
    }

    public function getArtcodAttribute($value)
    {
        return strval($value);
    }


    public function getPriceForUser($usutarcod)
    {
        $precioTarifa = Precio::where('pretarcod', $usutarcod)
                        ->where('preartcod', $this->artcod)
                        ->first();
        return $precioTarifa ? $precioTarifa->preimp : null;
    }

    public function getPriceWithOffer($usuofecod, $today){
        $offerPrice = OfertaC::where('ofcartcod', $this->artcod)
                             ->where('ofccod', $usuofecod)
                             ->whereDate('ofcfecfin', '>=', $today)
                             ->first();
        if ($offerPrice) {
            return [
                'ofcimp' => $offerPrice->OFCIMP,
                'ofctip' => $offerPrice->ofctip
            ];
        } else {
            return null;
        }
    }
    
}
