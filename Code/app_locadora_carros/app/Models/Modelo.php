<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function rules() {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpg,jpeg|max:2048',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }


    public function marca() {
        // Um modelo pertence a uma marca.
        return $this->belongsTo('App\Models\Marca');
    }

    public function carros() {
        // Um modelo pode ter muitos carros.
        //return $this->hasMany('App\Models\Carro');
        return $this->hasMany('App\Models\Carro')->select('id', 'modelo_id', 'placa', 'disponivel', 'km');
    }
}
