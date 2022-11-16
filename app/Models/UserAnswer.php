<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['user_test_id', 'question_id', 'variant_id', 'correct'];

    public function user_test()
    {
        return $this->belongsTo(UserTest::class);
    }
}
