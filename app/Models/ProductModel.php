<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'sku_product',
        'sku_factory',
        'factory_name',
        'factory_code',
        'product_description',
        'product_weight',
        'chain_weight',
        'stone_weight',
        'nailing_amount',
        'assembly_value',
        'rhodium_value',
        'work_value',
        'aditional_costs',
        'profit_margin',
        'nf_value',
        'status',
        'created_at',
        'updated_at'
    ];
}
