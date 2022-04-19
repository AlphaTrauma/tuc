<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $appends = ['alias'];

    protected $fillable = ['title', 'description', 'length', 'html', 'slug', 'teacher_id', 'direction_id'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Курс обучения',
            'path' => '/all_courses'
        ];
    }
}
