<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    use HasFactory;

    protected $fillable = [
        'yard_code',
        'yard_name',
        'yard_phone',
        'yard_address',
    ];

    protected $primaryKey = 'yard_code';
    public $incrementing = false;
    protected $keyType = 'string';
} 