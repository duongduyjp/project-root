<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $fillable = [
        'shelf_id',
        'shelf_name',
        'yard_code'
    ];

    /**
     * Get the yard that owns the shelf.
     */
    public function yard()
    {
        return $this->belongsTo(Yard::class, 'yard_code', 'yard_code');
    }
}
