<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'question_id', 'ordering', 'correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
