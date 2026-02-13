<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'phone_number',
        'date_of_birth',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}