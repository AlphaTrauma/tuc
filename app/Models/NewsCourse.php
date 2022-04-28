<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCourse extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'course_id'];
}
