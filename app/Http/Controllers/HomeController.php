<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Empresa;
use App\Models\Aprendiz;
use App\Models\Instructor;

class HomeController extends Controller
{
    public function index()
    {
        $totalProyectos = Proyecto::whereIn('estado', ['aprobado', 'en_progreso'])->count();
        $totalEmpresas = Empresa::where('activo', 1)->count();
        $totalAprendices = Aprendiz::where('activo', true)->count();
        $totalInstructores = Instructor::where('activo', true)->count();

        return view('index', compact(
            'totalProyectos',
            'totalEmpresas',
            'totalAprendices',
            'totalInstructores'
        ));
    }
}