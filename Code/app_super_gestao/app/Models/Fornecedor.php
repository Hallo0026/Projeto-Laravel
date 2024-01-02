<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores'; // Definindo o nome da tabela manualmente.
    protected $fillable = ['nome', 'site', 'uf', 'email']; // Autorizando que o método create receba esses parâmetros

    public function produtos() {
        return $this->hasMany('App\Models\Item', 'fornecedor_id', 'id'); // {model}, {FK}, {coluna PK da tabela mapeada}
    }

}
