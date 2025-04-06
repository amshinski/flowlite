<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TaskUser extends Pivot
{
    use HasUuids;

    protected $table = 'task_user';

    protected $primaryKey = ['task_id', 'user_id'];

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id',
    ];
}
