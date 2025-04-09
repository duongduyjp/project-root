<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_name',
        'name',
        'address',
        'phone',
        'closing_date',
        'status',
    ];

    protected $casts = [
        'closing_date' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}


