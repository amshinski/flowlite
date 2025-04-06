<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends BaseModel
{
    use HasUuids;

    protected $table = 'files';

    protected $fillable = [
        'path',
        'name'
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return asset("storage/{$this->path}");
    }
}
