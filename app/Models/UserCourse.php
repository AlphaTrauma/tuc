<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'status'];
    protected $dates = ['done_at'];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->load(['course', 'course.blocks']);
            foreach($model->course->blocks as $block):
                $model->user_blocks()->create(['user_course_id' => $model->course->id, 'block_id' => $block->id,
                    'ordering' => $block->ordering]);
            endforeach;

        });

        self::deleting(function($model){
            $model->user_blocks->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user_blocks()
    {
        return $this->hasMany(UserBlock::class);
    }
}
