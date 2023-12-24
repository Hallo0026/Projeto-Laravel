<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores'; // Definindo o nome da tabela manualmente.
    protected $fillable = ['nome', 'site', 'uf', 'email']; // Autorizando que o método create receba esses parâmetros

}
