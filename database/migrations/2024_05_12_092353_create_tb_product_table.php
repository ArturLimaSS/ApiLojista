<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_produto', function (Blueprint $table) {
            $table->id();
            $table->string('sku_produto');
            $table->string('sku_fabricante');
            $table->string('nome_fabricante');
            $table->string('codigo_fabricante');
            $table->text('descricao_produto');
            $table->double('peso_produt');
            $table->double('peso_corrente');
            $table->double('peso_pedras');
            $table->string('cravacao_quantidade');
            $table->double('valor_montagens');
            $table->double('valor_rodio');
            $table->double('valor_mao_de_obra');
            $table->double("custos_adicionais");
            $table->double("margem_lucro");
            $table->double("valor_nf");
            $table->enum("status", ["Ativo", "Inativo"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_product');
    }
};
