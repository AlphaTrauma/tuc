<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    use HasFactory;

    protected $appends = ['alias'];

    protected $fillable = ['ordering', 'description', 'title', 'image_id', 'button_text', 'link'];

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function getAliasAttribute(){
        return [
            'title' => 'Слайд',
            'path' => null
        ];
    }
}
