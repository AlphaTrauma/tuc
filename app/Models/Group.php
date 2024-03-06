<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'user_groups';
    protected $fillable = ['contractor_id', 'end_date', 'start_date', 'number', 'contract', 'protocol',
        'chairman', 'member1', 'member2', 'secretary', 'chairman_pos', 'member1_pos', 'member2_pos', 'secretary_pos',
        'chairman2', 'member3', 'member4', 'secretary2', 'chairman2_pos', 'member3_pos', 'member4_pos', 'secretary2_pos'];
    protected $dates = ['end_date', 'start_date'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class);
    }
}
