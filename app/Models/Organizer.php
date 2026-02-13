<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Organizer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'organizers';
    protected $primaryKey = 'organizer_id';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'phone_number',
        'date_of_birth',
        'organization_name',
        'company_name',
        'website',
        'business_reg_no',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_banned' => 'boolean',
    ];

    // Relationships
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }
}