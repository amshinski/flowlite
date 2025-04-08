<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($project) {
            $project->creator_id = auth()->id();
        });
    }
}
