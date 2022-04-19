<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['filepath', 'filename', 'size'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            File::deleteDirectory($item->filepath);
        });
    }

    public static function add($file, $path, $model){
        if(isset($model->image->filepath)) $model->image->delete();
        $filename = $file->getClientOriginalName();
        if(!File::exists($path)) File::makeDirectory($path, 0777, true);
        $filepath = 'uploads/'.$path.'/'.$filename;
        $size = $file->getSize();
        $file->move(public_path('uploads/'.$path), $filename);
        $model->image()->create(['filepath' => $filepath, 'filename' => $filename, 'size' => $size]);
    }

    public function entity()
    {
        return $this->morphTo();
    }

    public function readableSize()
    {
        if ( $this->size > 0 ):
            $size = (int) $this->size;
            $base = log($size) / log(1024);
            $suffixes = array(' Байт', ' КБ', ' МБ', ' ГБ', ' ТБ');
            return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
        endif;
    }

}
