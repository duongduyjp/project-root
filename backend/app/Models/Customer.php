<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'address',
        'customer_type',
        'closing_date',
    ];

    protected $casts = [
        'closing_date' => 'integer',
    ];
} 

public function sites()
{
    return $this->hasMany(Site::class, 'customer_id');
}