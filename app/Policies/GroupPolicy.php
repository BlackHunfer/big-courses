<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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

    public function groupProtected(User $user, Group $group)
    {
        if($user->hasRole('teacher')){
            $admin_id = $user->teacher_admins[0]->id;
        }

        if($user->hasRole('administrator')){
            $admin_id = $user->id;
        }

        return $admin_id === $group->admin_id;
    }
}
