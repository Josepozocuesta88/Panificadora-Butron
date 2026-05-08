<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albarancc extends Model
{
    use HasFactory;

    protected $table = 'albarancc';
    protected $primaryKey = 'acccod';
    public $incrementing = false;
    protected $keyType = 'string';

    
    protected $fillable = [
        'accclicod',
        'acccencod',  
        'aclartcod',
        'aclcan', 
        'aclpretot',
        'accfec'
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'aclartcod', 'artcod');
    }
}