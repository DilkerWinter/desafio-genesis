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

    public function viagens()
    {
        return $this->hasMany(Viagem::class);
    }
}
