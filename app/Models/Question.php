<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'test_id', 'ordering', 'correct'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
