<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'user_groups';
    protected $fillable = ['contractor_id', 'end_date', 'start_date'];
    protected $dates = ['end_date', 'start_date'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class);
    }
}
