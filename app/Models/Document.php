<?php

namespace App\Models;

use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Document extends Model
{
    use HasFactory, FileTrait;

    public function entity()
    {
        return $this->morphTo();
    }


}
