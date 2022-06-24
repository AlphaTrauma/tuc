<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'html', 'slug'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function directions()
    {
        return $this->hasMany(Direction::class);
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Формы обучения',
            'path' => '/all_types'
        ];
    }
}
