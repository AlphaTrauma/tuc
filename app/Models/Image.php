<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    use HasFactory, FileTrait;

    protected $fillable = ['filepath', 'filename', 'size'];

    public static function add($file, $path, $model){
        if(isset($model->image->filepath)) $model->image->delete();
        $filename = $file->getClientOriginalName();
        if(!File::exists($path)) File::makeDirectory($path, 0777, true);
        $filepath = 'uploads/'.$path.'/'.$filename;
        $size = $file->getSize();
        $file->move(public_path('uploads/'.$path), $filename);

        return $model->image()->create(['filepath' => $filepath, 'filename' => $filename, 'size' => $size]);
    }

    public static function addTo($file, $path, $model){
        $filename = $file->getClientOriginalName();
        if(!File::exists($path)) File::makeDirectory($path, 0777, true);
        $filepath = 'uploads/'.$path.'/'.$filename;
        $size = $file->getSize();
        $file->move(public_path('uploads/'.$path), $filename);
        return $model->images()->create(['filepath' => $filepath, 'filename' => $filename, 'size' => $size]);
    }

    public function entity()
    {
        return $this->morphTo();
    }

}
