<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // CategoriaController.php
    public function getCategoriasPorTipo($tipo)
    {
        $categorias = Categoria::where('tipo', $tipo)->orderBy('nome')->get();
        return response()->json($categorias);
    }
}
