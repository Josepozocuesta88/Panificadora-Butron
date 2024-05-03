<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'users_log';
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'email',
        'usuclicod',
        'usucencod',
        'fechorentrada',
        'fechorsalida',
    ];

}
