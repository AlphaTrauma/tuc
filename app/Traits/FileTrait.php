<?php


namespace App\Traits;

use Illuminate\Support\Facades\File;

trait FileTrait
{
    public static function bootFileTrait()
    {
        static::deleted(function ($item) {
            File::deleteDirectory($item->filepath);
        });
    }

    public function readableSize()
    {
        if ($this->size > 0):
            $size = (int) $this->size;
            $base = log($size) / log(1024);
            $suffixes = array(' Байт', ' КБ', ' МБ', ' ГБ', ' ТБ');
            return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
        endif;
    }
}
