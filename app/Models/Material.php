<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'block_id', 'ordering', 'material_type', 'url', 'document_id', 'download'];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        $icon = null;
        $title = null;
        switch($this->material_type):
            case('image'):
                $icon = 'image';
                $title = 'Изображение';
            break;
            case('youtube'):
                $icon = 'youtube';
                $title = 'Видео Youtube';
            break;
            case('pdf'):
                $icon = 'file-pdf';
                $title = 'PDF';
            break;
            case('link'):
                $icon = 'link';
                $title = 'Внешняя ссылка';
            break;
        endswitch;
        return compact('title', 'icon');
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function course()
    {
        $this->HasOneThrough(Course::class,Block::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'entity');
    }

    public function document(){
        return $this->morphOne(Document::class, 'entity');
    }

    public function previous(){
        return Material::where([['block_id', $this->block_id], ['ordering', ($this->ordering - 1)]])->first();
    }

    public function next(){
        return Material::where([['block_id', $this->block_id], ['ordering', ($this->ordering + 1)]])->first();
    }
}
