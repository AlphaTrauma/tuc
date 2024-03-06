<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_at',
        'name',
        'patronymic',
        'last_name',
        'email',
        'group_id',
        'document',
        'doc_series',
        'snils',
        'gender',
        'inn',
        'education',
        'doc_education',
        'birth_date',
        'phone',
        'position',
        'organization',
        'role',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['birth_date'];

    public function image()
    {
        return $this->morphOne(Image::class, 'entity');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, UserCourse::class);
    }

    public function user_courses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function latestCourse()
    {
        return $this->hasOne(UserCourse::class)->orderByDesc('created_at');
    }

    public function active_courses()
    {
        return $this->hasMany(UserCourse::class)->where('status', false);
    }

    public function completed_courses()
    {
        return $this->hasMany(UserCourse::class)->where('status', true);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}
