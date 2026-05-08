<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCategoria extends Model
{
    use HasFactory;

    protected $table = "qanet_clientecategoria";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = [
        'clicod',
        'clicencod',
        'catcod',
    ];
}
