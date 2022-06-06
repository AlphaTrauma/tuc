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
            $model->load(['block', 'block.materials']);
            foreach($model->block->materials as $material):
                $model->user_materials()->create(['user_block_id' => $model->block->id, 'material_id' => $material->id,
                    'ordering' => $material->ordering]);
            endforeach;

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

    public function user_materials()
    {
        return $this->hasMany(UserMaterial::class);
    }

    public function previous(){
        return UserBlock::where([['user_course_id', $this->user_course_id], ['ordering', ($this->ordering - 1)]])->first();
    }

    public function next(){
        return UserBlock::where([['user_course_id', $this->user_course_id], ['ordering', ($this->ordering + 1)]])->first();
    }
}
