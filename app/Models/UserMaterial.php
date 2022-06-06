<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['user_block_id', 'material_id', 'status', 'ordering'];

    public function user_block()
    {
        return $this->belongsTo(UserBlock::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function previous(){
        return UserMaterial::where([['user_block_id', $this->user_block_id], ['ordering', ($this->ordering - 1)]])->first();
    }

    public function next(){
        return UserMaterial::where([['user_block_id', $this->user_block_id], ['ordering', ($this->ordering + 1)]])->first();
    }

}
