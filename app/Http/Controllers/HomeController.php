<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Empresa;
use App\Models\Aprendiz;

class HomeController extends Controller
{
    public function index()
    {
        $totalProyectos = Proyecto::activos()->count();
        $totalEmpresas = Empresa::where('activo', 1)->count();
        $totalAprendices = Aprendiz::activos()->count();

        return view('index', compact(
            'totalProyectos',
            'totalEmpresas',
            'totalAprendices'
        ));
    }
}