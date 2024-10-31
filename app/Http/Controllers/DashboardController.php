<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $saldo = auth()->user()->carteira->saldo;

        $transacoes = auth()->user()->carteira->transacoes()->with('categoria')->latest()->take(5)->get();

        /* dd($transacoes); */

        $totalEntradas = $user->carteira->transacoes()->where('tipo', 1)->sum('valor');
        $totalDespesas = $user->carteira->transacoes()->where('tipo', 2)->sum('valor');




        return view('dashboard', [
            'saldo' => $saldo,
            'transacoes' => $transacoes,
            'totalEntradas' => $totalEntradas,
            'totalDespesas' => $totalDespesas,

        ]);
    }

    public function categorias()
    {

        $user = Auth::user();

        $gastosPorCategoria = $user->carteira->transacoes()
            ->where('tipo', 2) // Filtra apenas despesas
            ->selectRaw('categoria_id, SUM(valor) as total')
            ->groupBy('categoria_id')
            ->with('categoria') // Carrega o nome da categoria
            ->get();

        $entradasPorCategoria = $user->carteira->transacoes()
            ->where('tipo', 1)
            ->selectRaw('categoria_id, SUM(valor) as total')
            ->groupBy('categoria_id')
            ->with('categoria') // Carrega o nome da categoria
            ->get();

        return view('categorias', [
            'gastosPorCategoria' => $gastosPorCategoria,
            'entradasPorCategoria' =>  $entradasPorCategoria
        ]);
    }
}
