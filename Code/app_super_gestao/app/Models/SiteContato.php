<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
Identificando o nome da tabela:

* SiteContato -> Site_Contato -> site_contato -> site_contatos

*/
class SiteContato extends Model
{
    use HasFactory;

    protected $table = 'site_contatos'; // Definindo o nome da tabela manualmente.
    protected $fillable = ['nome', 'telefone', 'email', 'motivo_contatos_id', 'mensagem'];

}
