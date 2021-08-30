<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Speciality;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialityPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function specialityProtected(User $user, Speciality $speciality)
    {
        if($user->hasRole('teacher')){
            $admin_id = $user->teacher_admins[0]->id;
        }

        if($user->hasRole('administrator')){
            $admin_id = $user->id;
        }

        return $admin_id === $speciality->admin_id;
    }
}
