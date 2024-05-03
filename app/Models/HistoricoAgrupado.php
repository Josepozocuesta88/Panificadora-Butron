<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoAgrupado extends Model
{
    use HasFactory;
    protected $table = 'v_historico_agrupado'; 

    public $incrementing = false;
    public $timestamps = false;
}
