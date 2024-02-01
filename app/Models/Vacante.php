<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'salario_id',
        'categoria_id',
        'empresa',
        'ultimo_dia',
        'descripcion',
        'imagen',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ultimo_dia' => 'datetime'
    ];

    public function categoria()
    {
        // Una vacante pertenece a una categoría
        return $this->belongsTo(Categoria::class);
    }

    public function salario()
    {
        // Una vacante tiene asociado un rango de salario
        return $this->belongsTo(Salario::class);
    }

    public function candidatos()
    {
        // Una vacante tiene muchos candidatos
        return $this->hasMany(Candidato::class)->orderBy('created_at', 'DESC');
    }

    public function reclutador()
    {
        // Una vacante tiene un reclutador
        return $this->belongsTo(User::class, 'user_id');
    }
}
