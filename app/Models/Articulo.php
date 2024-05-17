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
        'artcatcodw1'
    ];
    // Relaciones en laravel: son métodos que devuelven una instancia 
    // de una de las clases de relación de Laravel: hasOne, hasMany, belongsTo, belongsToMany, etc.
    //  Estos métodos no ejecutan la consulta de la relación, sino que devuelven una instancia 
    //  de la relación que puedes usar para consultar la relación.
    // no se puede usar el metodo with de Eloquent con un metodo de un modelo porque with() espera 
    // una relación no un resultado de una relacion (el resultado de una relacion sería p.e. primeraImagen)
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
    // metodos
    public function primeraImagen()
    {
        $imagen = $this->imagenes()->first();
        return $imagen ? $imagen->imanom : null;
    }

    // Definimos un accesor siguiendo la convención de nomenclatura de laravel para accesores y conmutadores
    // con ello laravel sabe con que campo de la tabla lo va a usar
    // Para lo que sirve: convierte el valor de artcod a una cadena antes de devolverlo
    // esto lo hago porque se estaba interpretando la primary key como un valor de tipo entero a pesar de ser un string, 
    // esto podria estar ocurriendo o bien por un bug de laravel o bien por un bug en el driver de la base de datos.
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
