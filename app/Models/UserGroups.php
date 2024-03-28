<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    use HasFactory;

    protected $table = 'user_groups_link';
    protected $fillable = ['user_id', 'group_id'];
}
