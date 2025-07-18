<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorista extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'motoristas';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cnh',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function viagens()
    {
        return $this->belongsToMany(Viagem::class, 'motorista_viagem', 'motorista_id', 'viagem_id');
    }
}
