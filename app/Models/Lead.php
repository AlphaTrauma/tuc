<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'phone', 'name', 'comment', 'page', 'course', 'status', 'user_id', 'leads_groups_id'];

    public static $types = ['height' => 'Высота'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
