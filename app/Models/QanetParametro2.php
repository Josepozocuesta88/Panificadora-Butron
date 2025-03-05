<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QanetParametro2 extends Model
{
  use HasFactory;

  protected $table = 'qanet_parametro2';
  protected $primaryKey = false;
  public $incrementing = false;
  public $timestamps = false;

  protected $fillable = [
    'connom',
    'conentero',
    'contexto',
    'condoble',
  ];
}
