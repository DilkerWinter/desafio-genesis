<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viagem extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'viagens';

    protected $fillable = [
        'motorista_id',
        'veiculo_id',
        'km_inicial',
        'km_final',
        'data_hora_inicial',
        'data_hora_final'
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
