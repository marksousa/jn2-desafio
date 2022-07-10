<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function cadastro_de_um_novo_cliente()
    {
        $this->withoutExceptionHandling();
        $atributos = Cliente::factory()->raw();
        $this->postJson(route('cliente.store'), $atributos);
        $this->assertDatabaseHas('clientes', $atributos);
    }

    /** @test */
    public function obrigatorio_informar_o_nome_do_cliente()
    {
        $atributos = Cliente::factory()->raw(['nome' => '']);
        $this->postJson(route('cliente.store'), $atributos)->assertJsonValidationErrorFor('nome');
    }

    /** @test */
    public function obrigatorio_informar_o_telefone_do_cliente()
    {
        $atributos = Cliente::factory()->raw(['telefone' => '']);
        $this->postJson(route('cliente.store'), $atributos)->assertJsonValidationErrorFor('telefone');
    }

    /** @test */
    public function obrigatorio_informar_o_cpf_do_cliente_()
    {
        $atributos = Cliente::factory()->raw(['cpf' => '']);
        $this->postJson(route('cliente.store'), $atributos)->assertJsonValidationErrorFor('cpf');
    }

    /** @test */
    public function obrigatorio_informar_a_placa_do_carro_do_cliente_()
    {
        $atributos = Cliente::factory()->raw(['placa_do_carro' => '']);
        $this->postJson(route('cliente.store'), $atributos)->assertJsonValidationErrorFor('placa_do_carro');
    }

    /** @test */
    public function edicao_das_informacoes_de_um_cliente_ja_existente()
    {
        $this->withoutExceptionHandling();
        $cliente = Cliente::factory()->create([
            'nome' => 'Nome de Solteiro',
            'placa_do_carro' => 'RSH-2112'
        ]);
        $atributosEditados = [
            'nome' => 'Nome de Casado',
            'telefone' => '01122334455',
            'cpf' => '22966078880',
            'placa_do_carro' => 'MJD-2345'
        ];
        $this->putJson(route('cliente.update', $cliente->id), $atributosEditados);
        $this->assertDatabaseHas('clientes', $atributosEditados);
    }

    /** @test */
    public function remocao_de_um_cliente_existente()
    {
        $this->withoutExceptionHandling();
        $cliente = Cliente::factory()->create([
            'nome' => 'Cliente Teste que Sera Removido',
        ]);
        $this->deleteJson(route('cliente.destroy', $cliente->id));
        $this->assertDatabaseMissing('clientes', ['nome' => 'Cliente Teste que Sera Removido']);
    }

    /** @test */
    public function consulta_de_dados_de_um_cliente()
    {
        $this->withoutExceptionHandling();
        $cliente = Cliente::factory()->create([
            'nome' => 'Mark Sousa',
        ]);
        $consulta = $this->getJson(route('cliente.show', $cliente->id));
        $consulta->assertJson(['nome' => 'Mark Sousa']);
    }

    /** @test */
    public function consulta_de_um_cliente_com_numero_final_de_placa_9()
    {
        $this->withoutExceptionHandling();
        $atributos = [
            'nome' => 'Mark Sousa',
            'telefone' => '01122334455',
            'cpf' => '22966078880',
            'placa_do_carro' => 'ABC-9999'
        ];
        Cliente::factory()->create($atributos);
        $this->getJson(route('consulta.final-placa', ['numero' => 9]))
            ->assertJsonCount(1)
            ->assertJsonFragment($atributos)
            ->assertJsonStructure([
                '*' => [
                    'nome',
                    'telefone',
                    'cpf',
                    'placa_do_carro'
                ]
            ]);
    }

    /** @test */
    public function consulta_de_10_clientes_com_numero_final_de_placa_9()
    {
        $this->withoutExceptionHandling();
        Cliente::factory(10)->create([
            'placa_do_carro' => $this->faker->regexify('[A-Z]{3}-[0-9]{3}[9]')
        ]);
        Cliente::factory(50)->create([
            'placa_do_carro' => $this->faker->regexify('[A-Z]{3}-[0-9]{3}[0-8]{1}')
        ]);
        $this->getJson(route('consulta.final-placa', ['numero' => 9]))
            ->assertJsonCount(10)
            ->assertJsonStructure([
                '*' => [
                    'nome',
                    'telefone',
                    'cpf',
                    'placa_do_carro'
                ]
            ]);
    }
}