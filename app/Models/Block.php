<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'ordering', 'course_id'];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function previous(){
        return Block::where([['course_id', $this->course_id], ['ordering', ($this->ordering - 1)]])->first();
    }

    public function next(){
        return Block::where([['course_id', $this->course_id], ['ordering', ($this->ordering + 1)]])->first();
    }
}
