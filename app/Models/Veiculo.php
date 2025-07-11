<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'modelo',
        'ano',
        'data_aquisicao',
        'km_aquisicao',
        'renavam',
        'placa',
    ];

    protected $casts = [
        'ano' => 'integer',
        'km_aquisicao' => 'integer',
    ];

    public function viagens()
    {
        return $this->hasMany(Viagem::class);
    }
}
