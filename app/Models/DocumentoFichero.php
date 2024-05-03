<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoFichero extends Model
{
    protected $table = 'qdocumento_fichero';

    public $timestamps = false;

    protected $primaryKey = 'doccon';

    protected $fillable = [
        'doccon',
        'doctip',
        'docser',
        'doceje',
        'docnum',
        'docord',
        'docfichero'
    ];


    public function documento() {
        return $this->belongsTo(Documento::class, 'doccon', 'qdocumento_id');
    }

}

