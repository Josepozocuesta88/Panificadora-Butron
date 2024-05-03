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
}
