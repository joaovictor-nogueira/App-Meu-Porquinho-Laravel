<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriaIdToTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transacoes', function (Blueprint $table) {
            $table->foreignId('categoria_id')->after('carteira_id')->nullable()->constrained('categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transacoes', function (Blueprint $table) {
            // Primeiro remove a restrição de chave estrangeira
            $table->dropForeign(['categoria_id']);

            // Em seguida, remove a coluna 'category_id'
            $table->dropColumn('categoria_id');
        });
    }
}
