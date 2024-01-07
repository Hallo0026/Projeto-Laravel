<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    public function produtos() {
        //return $this->belongsToMany('App\Models\Produto', 'pedidos_produtos'); // Relacionamento com nomes padronizados.

        // Relacionamento com nomes despadronizados.
        /*
        * @param1 - Modelo do relacionamento NxN em relação ao modelo que estamos implementando.
        * @param2 - Tabela auxiliar que armazena os registros de relacionamento.
        * @param3 - Representa o nome da FK da tabela mapeada pelo modelo na tabela de relacionamento.
        * @param4 - Representa o nome da FK da tabela mapeada pelo modelo utilizado no relacionamento que estamos implementando
        */
        return $this->belongsToMany('App\Models\Item', 'pedidos_produtos', 'pedido_id', 'produto_id');


    }
}
