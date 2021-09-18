<?php

namespace App\Vendor;


class ConfigFileManagerHandler
{
    public function userField()
    {
        // return auth()->id();

        if(auth()->user()->hasRole('teacher')){
            $admin_id = auth()->user()->teacher_admins[0]->id;
        }

        if(auth()->user()->hasRole('administrator')){
            $admin_id = auth()->user()->id;
        }

        if(auth()->user()->hasRole('student')){
            $admin_id = auth()->user()->student_admins[0]->id;
        }
        
        return $admin_id.'/'.auth()->id();
    }
}
