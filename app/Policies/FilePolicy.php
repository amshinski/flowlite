<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    public function delete(User $user, File $file): bool
    {
        return $user->id === $file->uploaded_by ||
            $user->id === $file->fileable->creator_id;
    }
}
