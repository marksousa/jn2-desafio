<?php

namespace Tests\Unit;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use WithFaker;

    protected $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cliente = Cliente::make([
            'nome' => 'Leandro Oliveira',
            'telefone' => '11111111111',
            'cpf' => '02329589808',
            'placa_do_carro' => 'MCI-0488',
        ]);
    }

    /** @test */
    public function um_cliente_possui_nome()
    {
        $this->assertEquals('Leandro Oliveira', $this->cliente->nome);
    }

    /** @test */
    public function um_cliente_possui_telefone()
    {
        $this->assertEquals('11111111111', $this->cliente->telefone);
    }

    /** @test */
    public function um_cliente_possui_cpf()
    {
        $this->assertEquals('02329589808', $this->cliente->cpf);
    }

    /** @test */
    public function um_cliente_possui_placa_do_carro()
    {
        $this->assertEquals('MCI-0488', $this->cliente->placa_do_carro);
    }

    /** @test */
    public function um_cliente_tem_final_de_placa()
    {
        $this->assertEquals('8', $this->cliente->final_placa());
    }
}