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
            $model->load(['course', 'course.blocks.test']);
            foreach($model->course->blocks as $i => $block):
                $status = 0;
                if($i > 0) $status = ($model->course->blocks[$i - 1]->test and $block->test) ? 1 : 0;
                $model->user_blocks()->create(['user_course_id' => $model->course->id, 'block_id' => $block->id,
                    'ordering' => $block->ordering, 'status' => $status]);
            endforeach;

        });

        self::deleting(function($model){
            $model->user_blocks()->delete();
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

    public function first_material(){
        return $this->hasOneThrough(UserMaterial::class, UserBlock::class);
    }

    public function user_blocks()
    {
        return $this->hasMany(UserBlock::class);
    }
}
