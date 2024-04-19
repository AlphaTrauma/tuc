<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsGroup extends Model
{
    use HasFactory;

    protected $dates = ['course_date'];
    protected $fillable = ['course_date', 'type', 'comment', 'limit'];

    public function leads(){
        return $this->hasMany(Lead::class, 'leads_groups_id');
    }

    public function users(){
        return $this->hasManyThrough(User::class, Lead::class);
    }

}
