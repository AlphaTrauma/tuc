<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $table = "contractors";

    protected $fillable = ['name', 'short_name', 'TIN', 'description'];

    public function groups(){
        return $this->hasMany(Group::class);
    }

    public function users(){
        return $this->hasManyThrough(User::class, Group::class);
    }
}
