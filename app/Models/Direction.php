<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'html', 'slug', 'type_id'];

    protected $appends = ['alias'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Направления обучения',
            'path' => '/all_directions'
        ];
    }

}
