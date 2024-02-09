<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
        $role=Auth::user()->role;
        $id=Auth::user()->role_tbl_id;
        if($role=='admin')
        {
            $admin=(CommonFunctions::getAdmin($id))->toArray();
            return view('admin.profile',compact('admin'));
        }
        else   if($role == 'instructor')
        {

            $instructor=(CommonFunctions::getInstructor($id))->toArray();
            return view('instructor.profile',compact('instructor'));
        }
        else   if ($role=='student')
        {

            $student=(CommonFunctions::getStudent($id))->toArray();
            return view('student.profile',compact('student'));
        }
        else   if ($role=='qa_officer')
        {
            $qa=(CommonFunctions::getQA($id))->toArray();
            return view('qa_officer.profile',compact('qa'));

        }

        else   if ($role=='program_coordinator')
        {
            $programco=(CommonFunctions::getProgramCo($id))->toArray();
            return view('program_coordinator.profile',compact('programco'));

        }


    }

}
