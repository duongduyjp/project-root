<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_no',
        'item_name',
        'contract_type',
        'weight',
        'prices'
    ];

    protected $casts = [
        'prices' => 'array',
        'weight' => 'decimal:2'
    ];

    public static function rules()
    {
        return [
            'item_no' => 'required|string|max:10|unique:items,item_no',
            'item_name' => 'required|string|max:100',
            'contract_type' => 'required|in:1,2',
            'weight' => 'required|numeric|min:0',
            'prices' => 'required|array',
            'prices.daily' => 'required|array',
            'prices.daily.a' => 'required|numeric|min:0',
            'prices.daily.b' => 'required|numeric|min:0',
            'prices.daily.c' => 'required|numeric|min:0',
            'prices.sale' => 'required|array',
            'prices.sale.a' => 'required|numeric|min:0',
            'prices.sale.b' => 'required|numeric|min:0',
            'prices.sale.c' => 'required|numeric|min:0',
            'prices.basic' => 'required|array',
            'prices.basic.a' => 'required|numeric|min:0',
            'prices.basic.b' => 'required|numeric|min:0',
            'prices.basic.c' => 'required|numeric|min:0'
        ];
    }
} 