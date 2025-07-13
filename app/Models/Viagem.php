<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
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

    protected $casts = [
        'data_hora_inicial' => 'datetime',
        'data_hora_final' => 'datetime',
    ];

    protected $appends = ['distancia_total', 'duracao_total'];

    protected $with = ['motorista', 'veiculo'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    protected function distanciaTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => (!is_null($this->km_inicial) && !is_null($this->km_final))
                ? $this->km_final - $this->km_inicial
                : null
        );
    }

    protected function duracaoTotal(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->data_hora_inicial || !$this->data_hora_final) {
                    return null;
                }

                $diff = $this->data_hora_inicial->diff($this->data_hora_final);

                $horas = $diff->h + ($diff->days * 24);
                $minutos = $diff->i;
                $segundos = $diff->s;

                return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
            }
        );
    }
}
