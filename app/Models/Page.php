<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'html', 'slug', 'deletable'];

    protected $appends = ['alias'];

    use HasFactory;

    public function images()
    {
        return $this->morphMany(Image::class, 'entity');
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Страница',
            'path' => null
        ];
    }
}
