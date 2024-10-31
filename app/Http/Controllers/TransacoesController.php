<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransacoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        $query = $user->carteira->transacoes()->with('categoria')->latest();


        $data_request = null;

        if ($request->has('mes') && $request->has('ano')) {
            $mes = $request->input('mes');
            $ano = $request->input('ano');

            if ($mes && $ano) {
                $data_request = $mes . '/' . $ano;
                $query->whereMonth('created_at', $mes)->whereYear('created_at', $ano);
            }
        }




        $transacoes = $query->paginate(5);


        return view('transacoes.index', [
            'transacoes' => $transacoes,
            'data_request' => $data_request

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtenha todas as categorias e passe para a view
        $categorias = Categoria::orderBy('nome')->get();

        return view('transacoes.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = [
            'valor' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:1,2',
            'categoria' => 'required',
            'descricao' => 'max:200'
        ];

        $feedback = [
            'valor.required' => 'É necessário inserir um valor',
            'valor.min' => 'O valor deve ser maior que zero.',
            'valor.numeric' => 'O valor deve ser um número válido.',
            'tipo.required' => 'Qual a transação que deseja fazer ?',
            'categoria.required' => 'Qual é a categoria da transação?',
            'descricao.max' => 'A descrição só pode ter no máximo 200 caracteres',
        ];

        // Converte o valor para o formato correto antes de validar
        $valor = $request->input('valor');

        // Verifica se o valor não está vazio ou é uma string não numérica
        if (empty($valor) || !is_numeric(str_replace(',', '.', $valor))) {
            return redirect()->back()->withErrors(['valor' => 'O valor deve ser um número válido.'])->withInput();
        }

        // Converte o valor para float
        $valor = str_replace(',', '.', preg_replace('/\D/', '', $valor)) / 100;
        $request->merge(['valor' => $valor]); // Atualiza o valor no request

        // Validação
        $request->validate($regras, $feedback);

        $carteira = Auth::user()->carteira;

        $tipo = $request->input('tipo');
        $categoria = $request->input('categoria');
        $descricao = $request->input('descricao');

        // Verifica saldo se for um saque
        if ($tipo == 2 && $valor > $carteira->saldo) {
            return redirect()->route('dashboard')->with('error', 'Saldo insuficiente para saque.');
        }

        // Atualiza o saldo da carteira
        if ($tipo == 1) {
            $carteira->saldo += $valor; // Entrada
        } else {
            $carteira->saldo -= $valor; // Saída
        }

        $carteira->save(); // Salva as alterações na carteira

        // Cria a nova transação
        Transacao::create([
            'carteira_id' => $carteira->id,
            'categoria_id' => $categoria,
            'tipo' => $tipo,
            'valor' => $valor,
            'descricao' => $descricao
        ]);

        return redirect()->route('dashboard')->with('success', 'Transação realizada com sucesso.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function show(Transacao $transacao)
    {




        return view('transacoes.show', ['transacao' => $transacao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Transacao $transacao)
    {

        $categorias = Categoria::orderBy('nome')->get();

        return view('transacoes.edit', ['transacao' => $transacao, 'categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transacao $transacao)
    {
        $regras = [
            'valor' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:1,2',
            'categoria' => 'required',
            'descricao' => 'max:200'
        ];

        $feedback = [
            'valor.required' => 'É necessário inserir um valor',
            'valor.min' => 'O valor deve ser maior que zero.',
            'valor.numeric' => 'O valor deve ser um número válido.',
            'tipo.required' => 'Qual a transação que deseja fazer ?',
            'categoria.required' => 'Qual é a categoria da transação?',
            'descricao.max' => 'A descrição só pode ter no máximo 200 caracteres',
        ];

        $valor = $request->input('valor');

        // Verifica se o valor não está vazio ou é uma string não numérica
        if (empty($valor) || !is_numeric(str_replace(',', '.', $valor))) {
            return redirect()->back()->withErrors(['valor' => 'O valor deve ser um número válido.'])->withInput();
        }

        // Converte o valor para float
        $valor = str_replace(',', '.', preg_replace('/\D/', '', $valor)) / 100;
        $request->merge(['valor' => $valor]); // Atualiza o valor no request

        // Validação
        $request->validate($regras, $feedback);

        // Captura o saldo original da transação
        $tipoOriginal = $transacao->tipo;
        $valorOriginal = $transacao->valor;

        // Atualiza a transação
        $transacao->update($request->all());

        // Atualiza a carteira
        $carteira = Auth::user()->carteira;

        // Atualiza o saldo com base no tipo da transação original
        if ($tipoOriginal == 1) { // Se era uma entrada
            $carteira->saldo -= $valorOriginal; // Remove o valor original da carteira
        } else { // Se era uma saída
            $carteira->saldo += $valorOriginal; // Adiciona o valor original da carteira
        }

        // Adiciona o novo valor com base no novo tipo de transação
        if ($request->input('tipo') == 1) {
            $carteira->saldo += $valor; // Adiciona o novo valor se for entrada
        } else {
            $carteira->saldo -= $valor; // Remove o novo valor se for saída
        }

        $carteira->save(); // Salva as alterações na carteira

        return redirect()->route('dashboard')->with('success', 'Transação atualizada realizada com sucesso.');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Encontre a transação pelo ID
        $transacao = Transacao::findOrFail($id);

        // Recupere a carteira do usuário autenticado
        $carteira = Auth::user()->carteira;

        // Atualize o saldo da carteira com base no tipo da transação
        if ($transacao->tipo == 1) { // Se for uma entrada
            $carteira->saldo -= $transacao->valor; // Remove o valor da entrada
        } else { // Se for uma saída
            $carteira->saldo += $transacao->valor; // Adiciona o valor da saída
        }

        $carteira->save();

        $transacao->delete();

        return redirect()->route('dashboard')->with('success', 'Transação deletada com sucesso!');
    }
}
