<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;


class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke($file_path, Request $request)
    {
        $admin_id_url = explode("/", $file_path);
        $admin_id_url = (int)$admin_id_url[1];

        $user = $request->user();

        if($user->hasRole('teacher')){
            $admin_id_auth = $user->teacher_admins[0]->id;
        }

        if($user->hasRole('administrator')){
            $admin_id_auth = $user->id;
        }

        if($user->hasRole('student')){
            $admin_id_auth = $user->student_admins[0]->id;
        }

        // dd('dsadas');
        $info = pathinfo($file_path);
        $extension = $info['extension'];
        // dd($extension);
        if($extension == 'mp4' || $extension == 'webm'){
            $urlReferer = request()->headers->get('referer');
            if(!$urlReferer){
                abort(404);
            }
            // dd(request()->headers->get('referer'));
            $route = collect(\Route::getRoutes())->first(function($route) use($urlReferer){
                return $route->matches(request()->create($urlReferer));
             });
            // dd(\Request::server('HTTP_REFERER'));
            if($route->getName() == 'materials.create' || $route->getName() == 'materials.edit' || $route->getName() == 'student.materials.show' || $route->getName() == 'unisharp.lfm.show'){
                // dd("есть роут");
                // $local_path = '';
                if($admin_id_auth === $admin_id_url){
                    $local_path = config('filesystems.disks.private.root') . DIRECTORY_SEPARATOR . $file_path;
                }else{
                    abort(404);
                }
            }else{
                abort(404);
            }
        }else{
            $local_path = '';
            if($admin_id_auth === $admin_id_url){
                $local_path = config('filesystems.disks.private.root') . DIRECTORY_SEPARATOR . $file_path;
            }else{
                abort(404);
            }
        }
        // if(Request::route()->getName() == 'materials.create' || Request::route()->getName() == 'materials.edit'){

        // }

        // $local_path = '';
        // if($admin_id_auth === $admin_id_url){
        //     $local_path = config('filesystems.disks.private.root') . DIRECTORY_SEPARATOR . $file_path;
        // }else{
        //     abort(404);
        // }

        // if (!Storage::disk('local')->exists($file_path)) {
        //     abort(404);
        // }

        return response()->file($local_path);
    }
}
