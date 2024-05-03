<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// La tabla etiqueta consta de 3 campos (tagcod, tagnom y tagtip)
// En ella tendremos todas las etiquetas con las que relacionaremos los productos 
// (p.e.: podremos extraer todos los productos que contengan la etiqueta chocolate)
// Tendremos un tipo de etiqueta tagtip=1 que hace referencia a los alergenos, de esta manera esta tabla 
// nos servirá para encontrar productos que tengan gluten y para mostrar las imagenes de los alérgenos.

// NOTA: Tengase en cuenta que la relación se construye a través de la tabla qarticulo_etiqueta en la que tendremos 
// las claves foráneas etiartcod y etitagcod 
class Etiqueta extends Model
{
    use HasFactory;
    protected $table = 'qetiqueta';
    protected $primaryKey = 'tagcod';


    protected $fillable = [
        'tagnom'
    ];
    
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'qarticulo_etiqueta', 'artcod', 'etiartcod');
    }
}
