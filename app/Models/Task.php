<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends BaseModel
{
    use HasUuids;

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'title',
        'description',
        'status',
        'priority',
        'is_archived'
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
        'status' => StatusEnum::class,
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function maintainers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TaskUser::class)
            ->withPivot([])
            ->as('maintainer');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($task) {
            $task->creator_id = auth()->id();
        });

        static::created(function ($task) {
            $task->maintainers()->attach(auth()->id());
        });
    }
}
