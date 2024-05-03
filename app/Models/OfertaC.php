<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaC extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qofertac';
    use HasFactory;
    protected $fillable = [
        'ofcnum',
        'ofccod',
        'ofcartcod',
        'ofcfecini',
        'ofcfecfin',
        'ofccatcodw1',
        'OFCIMP',
        'ofctip',
        'ofcima'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'ofcfecini',
        'ofcfecfin',
        'ofcclicod'
    ];
    public function usuario()
    {
        return $this->belongsTo(OfertaC::class, 'usuofecod', 'ofccod');
    }
}