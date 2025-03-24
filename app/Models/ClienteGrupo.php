<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteGrupo extends Model
{
    use HasFactory;

    protected $table = "qanet_clientegrupo";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'clicod',
        'clicencod',
        'grucod',
    ];
}
