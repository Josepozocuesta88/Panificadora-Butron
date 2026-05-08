<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
  use HasFactory;

  protected $table = "qanet_representante";
  protected $primarykey = "rprcod";
  protected $autoincrement = false;

  protected $fillable = [
    'rprcod',
    'rprnom',
    'rprema',
    'rprdelcod',
    'rprsyn',
    'rpralmcod',
    'rprtarcod',
    'rprporcom',
    'rprporcom2',
    'rprtel'
  ];
}
