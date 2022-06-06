<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $appends = ['alias'];

    protected $fillable = ['title', 'description', 'length', 'price', 'html', 'slug', 'teacher_id', 'direction_id'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function blocks(){
        return $this->hasMany(Block::class);
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Курс обучения',
            'path' => '/all_courses'
        ];
    }
}
