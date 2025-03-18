<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido_linea;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    public $timestamps = false;


    protected $fillable = [
        'cliente_id',
        'accclicod',
        'acccencod',
        'estado',
        'fecha',
        'subtotal',
        'descuento',
        'descuento_porcentaje',
        'gastos_envio',
        'total',
        'env_nombre',
        'env_apellidos',
        'env_direccion',
        'env_cp',
        'env_municipio',
        'env_poblacion',
        'env_pais',
        'env_tfno_1',
        'env_tfno_2',
        'env_pais_txt',
        'iva_porcentaje',
        'iva_importe',
        'observaciones',
    ];
    public function pedidos_lineas()
    {
        return $this->hasMany(Pedido_linea::class, 'pedido_id', 'id');
    }
}
