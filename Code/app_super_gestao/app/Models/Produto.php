<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id'];

    // Verificando se há um registro relacionado em produto_detalhes com base na foreign key
    public function produtoDetalhe() {
        return $this->hasOne('App\Models\ProdutoDetalhe');
    }

}
