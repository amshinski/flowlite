<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;

class User extends Authenticatable
{
    use HasFactory;
    use HasTeams;
    use Notifiable;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'telegram_id',
        'name',
        'profile_photo_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token'
    ];

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'creator_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->attributes['profile_photo_url']
            ?? 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=EBF4FF&background=3B3C3D';
    }
}
