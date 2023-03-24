<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    protected $fillable = ['user_block_id', 'result', 'done_at', 'test_id'];

    protected $dates = ['done_at'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function($model){
            $model->user_answers()->delete();
        });
    }

    public function user_answers()
    {
        return $this->hasMany(UserAnswer::class, 'user_test_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

}
