<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;

    protected $table = 'qanet_estadistica';
    protected $primaryKey = 'estcon';
    public $incrementing = false;
    // protected $keyType = 'string';

    
    protected $fillable = [
        'estalbnum',
        'estalbimptot',  
        'estclicod',
        'estcencod', 
        'estartcod', 
        'estcan',
        'estpre',
        'estfecrea'
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'estartcod', 'artcod');
    }
}