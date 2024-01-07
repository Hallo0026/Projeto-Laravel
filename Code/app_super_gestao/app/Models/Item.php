<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id', 'fornecedor_id'];

    // Verificando se há um registro relacionado em produto_detalhes com base na foreign key
    public function itemDetalhe() {
        return $this->hasOne('App\Models\itemDetalhe', 'produto_id', 'id'); // '{model}', '{coluna}', '{fk}'
    }

    public function fornecedor() {
        return $this->belongsTo('App\Models\Fornecedor');
    }

}
