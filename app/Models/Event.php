<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'category_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'price',
        'location',
        'link',
        'picture_url',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function favoriteEvents()
    {
        return $this->hasMany(FavoriteEvent::class, 'event_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorite_events', 'event_id', 'user_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name ?? null;
    }

    public function getPictureUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // External URLs (e.g. Unsplash seed data) pass through unchanged
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Strip legacy '/storage/' prefix from old records
        if (str_starts_with($value, '/storage/')) {
            $value = substr($value, strlen('/storage/'));
        }

        return Storage::disk(config('filesystems.default'))->url($value);
    }
}