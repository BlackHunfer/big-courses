<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function teacherProtected(User $user, User $teacher)
    {

        $teacherAdminId = '';
        foreach ($teacher->teacher_admins as $teacher) {
            $teacherAdminId = $teacher->pivot->admin_id;
        }

        return $user->id === $teacherAdminId;
    }

    public function studentProtected(User $user, User $student)
    {

        if($user->hasRole('teacher')){
            $admin_id = $user->teacher_admins[0]->id;
            $student_id = $student->student_admins[0]->id;
        }

        if($user->hasRole('administrator')){
            $admin_id = $user->id;
            $student_id = $student->student_admins[0]->id;
        }

        return $admin_id === $student_id;
    }
}
