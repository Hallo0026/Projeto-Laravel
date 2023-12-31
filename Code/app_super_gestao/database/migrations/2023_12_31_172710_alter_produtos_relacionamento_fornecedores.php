<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Criando a coluna em produtos que irá receber a fk de fornecedores
        Schema::table('produtos', function(Blueprint $table) {

            // insere um registro de fornecedor para estabelecer um relacionamento, para assim evitar erros ao inserir a nova fk.
            $fornecedor_id = DB::table('fornecedores')->insertGetId([
                'nome'      => 'Fornecedor Padrão SG',
                'site'      => 'fornecedorpadraosg.com.br',
                'uf'        => 'pr',
                'email'     => 'contato@fornecedorpadraosg.com.br'
            ]);

            $table->unsignedBigInteger('fornecedor_id')->default($fornecedor_id)->after('id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function(Blueprint $table) {
            $table->dropForeign('produtos_fornecedor_id_foreign');
            $table->dropColumn('fornecedor_id');
        });
    }
};
