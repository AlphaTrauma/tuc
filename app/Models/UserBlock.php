<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    use HasFactory;

    protected $fillable = ['user_course_id', 'block_id', 'status', 'ordering'];
    protected $dates = ['done_at'];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->load(['block.test', 'block.materials']);
            foreach($model->block->materials as $material):
                $model->user_materials()->create(['user_block_id' => $model->block->id, 'material_id' => $material->id,
                    'ordering' => $material->ordering]);
            endforeach;
            if($model->block->test) $model->user_test()->create(['test_id' => $model->block->test->id, 'result' => 0]);

        });

        self::deleting(function($model){
            $model->user_materials()->delete();
        });
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Block::class);
    }

    public function user_course()
    {
        return $this->belongsTo(UserCourse::class);
    }

    public function user_materials()
    {
        return $this->hasMany(UserMaterial::class);
    }

    public function user_test()
    {
        return $this->hasOne(UserTest::class);
    }

    public function first_material()
    {
        return $this->hasMany(UserMaterial::class)->orderBy('ordering')->first();
    }

    public function last_material()
    {
        return $this->hasMany(UserMaterial::class)->orderByDesc('ordering')->first();
    }

    public function previous(){
        return UserBlock::where([['user_course_id', $this->user_course_id], ['ordering', ($this->ordering - 1)]])->first();
    }

    public function next(){
        return UserBlock::where([['user_course_id', $this->user_course_id], ['ordering', ($this->ordering + 1)]])->first();
    }
}
