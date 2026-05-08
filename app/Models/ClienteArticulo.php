<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteArticulo extends Model
{
    use HasFactory;

    protected $table = "qanet_clientearticulo";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    
    protected $fillable = [
        'clicod',
        'clicencod',
        'artcod',
    ];

    // public function getKey()
    // {
    //     return $this->attributes['clicod'] . ',' . $this->attributes['clicencod'] . ',' . $this->attributes['artcod'];
    // }

}
