<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = ['topic_id', 'word', 'meaning', 'image_path', 'sentences'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}

