<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'html', 'slug'];

    protected $appends = ['alias'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'news_courses', 'news_id', 'course_id');
    }

    public function courses_links()
    {
        return $this->hasMany(NewsCourse::class, 'news_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'entity');
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Новости и акции',
            'path' => '/news'
        ];
    }
}
