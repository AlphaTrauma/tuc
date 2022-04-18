<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'length', 'html', 'slug', 'teacher_id'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

}
