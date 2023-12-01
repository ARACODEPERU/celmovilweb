<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KenthaController extends Controller
{
    public function nosotros(){
        return view('kentha/nosotros');
    }
    
    public function contacto(){
        return view('kentha/contacto');
    }

    public function servicios(){
        return view('kentha/servicios');
    }

    public function proyectos(){
        return view('kentha/proyectos');
    }
}
