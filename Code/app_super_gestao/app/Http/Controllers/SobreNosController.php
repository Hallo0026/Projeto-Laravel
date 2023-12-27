<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Middleware\LogAcessoMiddleware;

class SobreNosController extends Controller
{

    /* // Adicionando interceptação do middlware no controlador manualmente.
    public function __construct() {
        $this->middleware(LogAcessoMiddleware::class);
    }
    */

    public function sobreNos() {
        return view('site.sobre-nos');
    }

}
