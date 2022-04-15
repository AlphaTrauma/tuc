<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['filepath', 'filename'];

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
        $file->move(public_path('uploads/'.$path), $filename);
        $model->image()->create(['filepath' => $filepath, 'filename' => $filename]);
    }

    public function entity()
    {
        return $this->morphTo();
    }

}
