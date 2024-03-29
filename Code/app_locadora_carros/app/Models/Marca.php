<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3|max:40',
            'imagem' => 'required|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'nome.unique' => 'O nome da marca já existe.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 10 caracteres.',
            'imagem.mimes' => 'A imagem deve ser do tipo PNG, JPG ou JPEG.',
        ];
    }


    public function modelos() {
        // Uma marca possui vários modelos.
        return $this->hasMany('App\Models\Modelo');
    }
}
