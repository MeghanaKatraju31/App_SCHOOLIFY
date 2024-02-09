<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function allChats(Request $request)
    {
        $chats =CommonFunctions:: get_all_chats();
//        print_r($chats);
//        exit;\
        $chat_with_id = $request->chat_with_id;
        $chat_from_id = $request->chat_from_id;
        $chat_with_role = $request->chat_with_role;
        $chat_from_role =$request->chat_from_role;
        $par_chat = CommonFunctions::get_particular_chat($chat_with_id,$chat_with_role,$chat_from_id,$chat_from_role);
        return view('others.allChats',compact('chats','par_chat','chat_with_role','chat_with_id'));
    }
    public function startChat(Request $request)
    {
        $chats =CommonFunctions:: get_all_chats();
//        print_r($chats);
//        exit;
        return view('others.startChat',compact('chats'));
    }
    public function getUsersList(Request $request)
    {
        $chatWith = $request->chatWith;



        // Fetch instructors based on the selected chatWith option

        $options='';
        $members= '';
        $user_id=Auth::user()->role_tbl_id;
        if($chatWith=='admin')
        {

            if (Auth::user()->role=='admin') {


                $admins=CommonFunctions::getAdminsForChat($user_id);
            }
            else
            {
                $admins=CommonFunctions::getAdmins();
            }

            // Generate HTML options for instructors
            $options = '<option value="">Select an Admin</option>';
            foreach ($admins as $admin) {
                $options .= '<option value="' . $admin->admin_id . '">' . $admin->admin_name . '</option>';
            }
        }
        else   if($chatWith == 'instructor')
        {

            if (Auth::user()->role=='instructor')
            {

                $instructors=CommonFunctions::getInstructorsForChat($user_id);
            }
            else
            {
                $instructors=CommonFunctions::getInstructors();
            }

            // Generate HTML options for instructors

            $options = '<option value="">Select an Instructor</option>';
            foreach ($instructors as $instructor) {
                $options .= '<option value="' . $instructor->instructor_id . '">' . $instructor->instructor_name . '</option>';
            }
        }
        else   if ($chatWith=='student')
        {

            if (Auth::user()->role=='student')
            {

                $students=CommonFunctions::getStudentsForChat($user_id);
            }
            else
            {
                $students=CommonFunctions::getStudents();
            }
            // Generate HTML options for instructors
            $options = '<option value="">Select a Student</option>';
            foreach ($students as $student) {
                $options .= '<option value="' . $student->std_id . '">' . $student->std_name . '</option>';
            }
        }
        else   if ($chatWith=='qa_officer')
        {

            if (Auth::user()->role=='qa_officer')
            {

                $qas=CommonFunctions::getQAsForChat($user_id);
            }
            else
            {
                $qas=CommonFunctions::getQAs();
            }
            // Generate HTML options for instructors
            $options = '<option value="">Select a QA Officer</option>';
            foreach ($qas as $qa) {
                $options .= '<option value="' . $qa->qa_id . '">' . $qa->qa_name . '</option>';
            }
        }

        else   if ($chatWith=='program_coordinator')
        {

            if (Auth::user()->role=='program_coordinator')
            {


                $pgs=CommonFunctions::getPGsForChat($user_id);
            }
            else
            {
                $pgs=CommonFunctions::getPGs();
            }
            // Generate HTML options for instructors
            $options = '<option value="">Select a Program Coordinator</option>';
            foreach ($pgs as $pg) {
                $options .= '<option value="' . $pg->program_co_id . '">' . $pg->program_co_name . '</option>';
            }
        }


        // Send the generated options as the response
        echo $options;
    }
    public function sendMessage(Request $request)
    {
        $role =$request->role;
        $chat_from_user_id=Auth::user()->role_tbl_id;
        $login_user_role=Auth::user()->role;


        $chat_to_user_id =$request->selectinstructor;

        $message = $request->message;

        $date= date("Y-m-d H:i:s");




        Chat::create([

            'chat_from_user_id' => $chat_from_user_id,
            'chat_to_user_id' => $chat_to_user_id,
            'chat_message' => $message,
            'chat_date_time' => $date,
            'chat_to_user_role' => $role,
            'chat_from_user_role' => $login_user_role,

        ]);
        return redirect()->back()->with('message',"Message sent successfully");
    }

}
