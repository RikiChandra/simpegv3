<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function Direktur(User $user)
    {
        return $user->role === 'direktur';
    }

    public function HRD(User $user)
    {
        return $user->role === 'hrd' || $user->role === 'direktur';
    }

    public function Karyawan(User $user)
    {
        return $user->role === 'karyawan';
    }

    public function __construct()
    {
        //
    }
}
