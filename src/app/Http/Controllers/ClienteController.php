<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all());
    }

    public function store(Request $request)
    {
        $atributos = $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'cpf' => 'required',
            'placa_do_carro' => 'required',
        ]);
        return response()->json(Cliente::create($atributos));
    }

    public function show(int $id)
    {
        return response()->json(Cliente::findOrFail($id));
    }

    public function update(int $id, Request $request)
    {
        $cliente = Cliente::findOrFail($id);
        $atributos = $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'cpf' => 'required',
            'placa_do_carro' => 'required',
        ]);
        $cliente->update($atributos);
        return response()->json($cliente);
    }

    public function destroy(int $id)
    {
        return Cliente::findOrFail($id)->delete();
    }

    public function all_final_placa($numero)
    {
        return Cliente::where('placa_do_carro', 'like', "%$numero")->get();
    }
}