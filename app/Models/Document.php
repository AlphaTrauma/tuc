<?php

namespace App\Models;

use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Document extends Model
{
    use HasFactory, FileTrait;

    protected $fillable = ['filepath', 'filename', 'size', 'ext', 'type', 'commentary'];

    public function entity()
    {
        return $this->morphTo();
    }

    public static function add($file, $path, $model){
        if(isset($model->document->filepath)) $model->document->delete();
        $filename = $file->getClientOriginalName();
        if(!File::exists($path)) File::makeDirectory($path, 0777, true);
        $filepath = 'uploads/documents/'.$path.'/'.$filename;
        $size = $file->getSize();
        $file->move(public_path('uploads/documents/'.$path), $filename);

        return $model->document()->create(['filepath' => $filepath, 'filename' => $filename, 'size' => $size, 'ext' => 'pdf']);
    }

}
