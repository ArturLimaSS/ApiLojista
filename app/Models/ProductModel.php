<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'tb_produto';
    protected $fillable = [
        'sku_produto',
        'sku_fabricante',
        'nome_fabricante',
        'codigo_fabricante',
        'descricao_produto',
        'peso_produt',
        'peso_corrente',
        'peso_pedras',
        'cravacao_quantidade',
        'valor_montagens',
        'valor_rodio',
        'valor_mao_de_obra',
        "custos_adicionais",
        "margem_lucro",
        "valor_nf",
        "status"
    ];
}
