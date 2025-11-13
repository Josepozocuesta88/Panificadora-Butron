<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{
    use HasFactory;

    protected $table = 'user_emails';

    protected $fillable = [
        'user_id',
        'email',
        'type_email',
        'is_primary',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tipos de correo disponibles
     */
    public static function getTypes()
    {
        return [
            'facturacion' => 'Facturación',
            'ventas' => 'Ventas',
            'admin' => 'Administración',
            'soporte' => 'Soporte Técnico',
            'logistica' => 'Logística',
            'general' => 'General',
        ];
    }

    /**
     * Obtener el nombre del tipo
     */
    public function getTypeNameAttribute()
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }

    /**
     * Scope para emails activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
