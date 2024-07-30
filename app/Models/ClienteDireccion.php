<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDireccion extends Model
{
    use HasFactory;

    protected $table = "clientes_direcciones";
    protected $primaryKey = 'dirid';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = [
        'dirid', 'cliid', 'dirnom',
        'dirape', 'dirdir', 'dirpob',
        'dirpai', 'dircp', 'dirtfno1', 'dirtfno2'
    ];
}
