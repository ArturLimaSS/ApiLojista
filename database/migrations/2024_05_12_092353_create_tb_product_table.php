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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('sku_product');
            $table->string('sku_factory');
            $table->string('factory_name');
            $table->string('factory_code');
            $table->text('product_description');
            $table->double('product_weight');
            $table->double('chain_weight');
            $table->double('stone_weight');
            $table->string('nailing_amount');
            $table->double('assembly_value');
            $table->double('rhodium_value');
            $table->double('work_value');
            $table->double("aditional_costs");
            $table->double("profit_margin");
            $table->double("nf_value");
            $table->enum("status", ["0", "1"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
