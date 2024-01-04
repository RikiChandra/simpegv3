<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function Admin(User $user)
    {
        return $user->role === 'admin';
    }

    public function HRD(User $user)
    {
        return $user->role === 'hrd';
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
