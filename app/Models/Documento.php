<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'qdocumento';

    protected $primaryKey = 'doccon';

    public $timestamps = false;

    protected $fillable = [
        'doctip',
        'docser',
        'doceje',
        'docnum',
        'docfec',
        'docclicod',
        'doccencod',
        'docimp',
        'docimptot',
        'docobs',
        'docfccser',
        'docfcceje',
        'docfccnum'
    ];

    // agregamos cualquier campo que no sea asignable
    // protected $guarded = [];

    // si necesitas trabajar con fechas, define tus campos de fecha
    protected $dates = ['docfec'];


    public function ficheros() {
        return $this->hasMany(DocumentoFichero::class, 'qdocumento_id', 'doccon');
    }
}
