<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{
    use HasUuids;

    protected $table = 'team_user';

    protected $primaryKey = ['team_id', 'user_id'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'role'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
