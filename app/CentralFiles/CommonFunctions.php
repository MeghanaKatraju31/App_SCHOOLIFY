<?php

namespace App\CentralFiles;


use App\Models\Curriculum;
use App\Models\ExamQuestionare;
use App\Models\InstructorPermissions;
use App\Models\Permissions;
use App\Models\PgPermissions;
use App\Models\Policy;
use App\Models\QaPermissions;
use App\Models\Recomendation;
use Mail;
use App\Mail\DemoEmail;
use App\Models\Admin;
use App\Models\Chat;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Exam;
use App\Models\Instructor;
use App\Models\InstructorActivity;
use App\Models\MainWebApp\Employee;
use App\Models\MainWebApp\EmployeeEducation;
use App\Models\MainWebApp\EmployeeSchedule;
use App\Models\MainWebApp\Gallery;
use App\Models\MainWebApp\ItemGallery;
use App\Models\MainWebApp\ItemReviews;
use App\Models\MainWebApp\ParticulerTypes;
use App\Models\MainWebApp\Users;
use App\Models\PgCoordinator;
use App\Models\PgCoordinatorActivity;
use App\Models\QaOfficer;
use App\Models\QaOfficerActivity;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentCourse;
use App\Models\StudentExam;
use App\Models\User;
use Carbon\Carbon;
use App\Models\MainWebApp\Item;
use App\Models\MainWebApp\Category;
use App\Models\MainWebApp\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\MainWebApp\TagAssignment;
use Illuminate\Support\Facades\DB;


class CommonFunctions
{
    static function getCurrentDate()
    {
        $current_date_time = date('Y-m-d H:i:s');
        return $current_date_time;
    }


    static function get_student($user_id)
    {
        $student = Student::where(['user_id'=>$user_id])->first()->toArray();
        return $student;
    }
    static function get_admin($user_id)
    {
        $admin = Admin::where(['user_id'=>$user_id])->first()->toArray();
        return $admin;
    }
    static function get_pg($user_id)
    {
        $pg = PgCoordinator::where(['user_id'=>$user_id])->first()->toArray();
        return $pg;
    }
    static function get_qa($user_id)
    {
        $qa = QaOfficer::where(['user_id'=>$user_id])->first()->toArray();
        return $qa;
    }
    static function get_instructor($user_id)
    {
        $ins= Instructor::where(['user_id'=>$user_id])->first()->toArray();
        return $ins;
    }
    static function getCurrentSemester($admissionYear) {
        // Assume a typical academic year with two semesters: Fall and Spring
        // Replace this with your specific logic to determine the current semester
        $currentYear = date('Y');
        $currentMonth = date('n');

        if ($currentMonth >= 1 && $currentMonth <= 6) {
            // Spring semester
            return ($currentYear - $admissionYear) * 2 + 2;
        } else {
            // Fall semester
            return ($currentYear - $admissionYear) * 2 + 1;
        }
    }

    static function get_student_courses($std_id, $semester) {
        $courses = StudentCourse::where(['std_id'=>$std_id,'semester_no'=>$semester])->get();


        return $courses;
    }
     static function get_course_details($course_id) {
        $courses = Course::where(['course_id'=>$course_id])->first();




        return $courses;


    }
    static function displayImage($imageData) {
        if (isset($imageData) && !empty($imageData)) {
            // If image data is available, display the image
            return 'data:image/jpeg;base64,' . base64_encode($imageData);
        } else {
            // If no image data, return an empty string
            return '';
        }
    }
    static function get_content_details($course_id) {

        $course_details = CourseContent::where(['course_id'=>$course_id])->get();


//        print_r($course_details);
//        exit;
//        if(empty($course_details))
//        {
//            return 'Not found';
//        }

        return $course_details;

    }
    static  function get_course_exams($course_id) {

        $exams = Exam::where(['course_id'=>$course_id])->get();


        return $exams;
    }
    static function get_studentexam_details($exam_id, $std_id) {
        $result = StudentExam::where(['exam_id'=>$exam_id,'std_id'=>$std_id])->first();



        if (!empty($result)) {
            return $result;
        } else {
            // No matching row found, return an empty array or null as per your preference
            return null;
        }
    }
    static function get_maximum_test($std_id, $semester) {

        $courses = StudentCourse::where(['std_id'=>$std_id,'semester_no'=>$semester])->get();

        $max_count=array();
        $count_len=0;
        $count_length=0;
        if (count($courses)>0) {
            foreach ($courses as $each_course) {
                $course_id = $each_course->course_id;
                $get_student_course_exam = self::get_course_exams($course_id);
                if(count($get_student_course_exam)>0)
                {
                    $count_length = count($get_student_course_exam);
                }

                $max_count[$count_len]=$count_length;
                $count_len++;
            }
        }
//                        print_r($max_count);
//                    exit();
        $maxValue = max($max_count);

        return $maxValue;
    }


    static function get_exam_details($exam_id) {
        $exams = Exam::where(['exam_id'=>$exam_id])->first();

        if (!empty($exams)) {

            $details = array();

            $exam= $exams->toArray();
            $details['exam_title']= $exam['exam_title'];
            $details['exam_desc']= $exam['exam_desc'];
            $details['exam_due_date']= $exam['exam_due_date'];
            $details['exam_total_marks']= $exam['exam_total_marks'];
            $details['exam_id']= $exam['exam_id'];
            $details['teacher_id']= $exam['teacher_id'];
            $details['status']= $exam['status'];
            $details['time_alloted']= $exam['time_alloted'];
            $details['course_id']= $exam['course_id'];

            $details['is_deleted']= $exam['is_deleted'];

            $result_student_exam = StudentExam::where(['exam_id'=>$exam_id])->first();

            if (empty($result_student_exam)) {
                $details['is_graded']=2;
            }
            else
            {
                $result_student_exam = StudentExam::where(['exam_id'=>$exam_id,'is_graded'=>0])->first();


                if (!empty($result_student_exam)) {
                    $details['is_graded']=0;
                }
                else
                {
                    $details['is_graded']=1;
                }

            }

            return $details;
        }

        return '';
    }

    static function get_studentexam_details_grade($exam_id, $std_id) {
        $result_student_exam = StudentExam::where(['exam_id'=>$exam_id,'std_id'=>$std_id,'is_graded'=>1])->first();



        return $result_student_exam;

    }
    static function getPercentage($marks_obtained,$total_marks) {
        // Perform database query to fetch questions
        // Replace the following line with your actual database query

        $marks_obtained = $marks_obtained;
        $total_marks = $total_marks;


        $percentage=($marks_obtained/$total_marks)*100;
        if ($percentage == (int)$percentage) {
            $formattedPercentage = (int)$percentage ;
        } else {
            $formattedPercentage = number_format($percentage, 2);
        }



        return $formattedPercentage;
    }

    static function get_all_chats(){

        $login_user_role = Auth::user()->role;
        $chat_from_user_id = Auth::user()->role_tbl_id;

        $all_chats=array();

        // Retrieve distinct chat_from_user_id where login user is the recipient
        $all_user_chats = Chat::where(['chat_from_user_id'=>$chat_from_user_id,'chat_from_user_role'=>$login_user_role])
            ->orWhere(['chat_to_user_id'=>$chat_from_user_id,'chat_to_user_role'=>$login_user_role])->get();




        $chats = [];

        $count=0;
        if (count($all_user_chats) > 0) {
            $all_chats =$all_user_chats->toArray() ;

            foreach ($all_chats as $each_chat)
            {


                $from_id = $each_chat['chat_from_user_id'];
                $from_role = $each_chat['chat_from_user_role'];
                $to_id = $each_chat['chat_to_user_id'];
                $to_role = $each_chat['chat_to_user_role'];
                $message = $each_chat['chat_message'];
                $date_time = $each_chat['chat_date_time'];
    //        echo "<pre>";
    //        print_r($each_chat);

                if(empty($chats))
                {

                    if ($from_id == $chat_from_user_id && $from_role==$login_user_role) {

                        $chats[$count]['chat_from_id'] =$from_id;
                        $chats[$count]['chat_from_role'] = $from_role;

                        $chats[$count]['chat_with'] =$to_id;
                        $chats[$count]['role'] = $to_role;
                        $chats[$count]['chat_message'] = $message;
                        $chats[$count]['chat_date'] = $date_time;
                        $count++;
                    } else if ($to_id == $chat_from_user_id && $to_role==$login_user_role) {

                        $chats[$count]['chat_from_id'] = $to_id ;
                        $chats[$count]['chat_from_role'] = $to_role;

                        $chats[$count]['chat_with'] =$from_id;
                        $chats[$count]['role'] = $from_role ;
                        $chats[$count]['chat_message'] = $message;
                        $chats[$count]['chat_date'] = $date_time;

                        $count++;
                    }
                }
                else
                {




                    $count_exist=0;
                    foreach ($chats as $each_chat_user) {
                        $existing_from_id = $each_chat_user['chat_from_id'];
                        $existing_from_role = $each_chat_user['chat_from_role'];
                        $existing_to_id = $each_chat_user['chat_with'];
                        $existing_to_role = $each_chat_user['role'];


                        //remove duplicates
                        if ((strcmp($from_id, $existing_from_id) == 0) && (strcmp($from_role, $existing_from_role) == 0)  && (strcmp($to_id, $existing_to_id) == 0)  && (strcmp($to_role, $existing_to_role) == 0)) {
                            $count_exist=0;

                            break;
                        } elseif ((strcmp($from_id, $existing_to_id) == 0)  && (strcmp($from_role, $existing_to_role) == 0) && (strcmp($to_id, $existing_from_id) == 0) && (strcmp($to_role, $existing_from_role) == 0)) {
                            $count_exist=0;

                            break;
                        } else {

                            $count_exist++;

                        }
                    }
                    if($count_exist>0)
                    {
                        if ($from_id == $chat_from_user_id && $from_role==$login_user_role) {

                            $chats[$count]['chat_from_id'] = $from_id;
                            $chats[$count]['chat_from_role'] = $from_role;

                            $chats[$count]['chat_with'] = $to_id;
                            $chats[$count]['role'] = $to_role;
                            $chats[$count]['chat_message'] = $message;
                            $chats[$count]['chat_date'] = $date_time;
                            $count++;
                        } else if ($to_id == $chat_from_user_id && $to_role==$login_user_role) {
                            $chats[$count]['chat_from_id'] = $to_id;
                            $chats[$count]['chat_from_role'] = $to_role;

                            $chats[$count]['chat_with'] = $from_id;
                            $chats[$count]['role'] = $from_role;
                            $chats[$count]['chat_message'] = $message;
                            $chats[$count]['chat_date'] = $date_time;

                            $count++;
                        }
                    }


                }

            }
        }

        return $chats;

    }
    static function get_chat_with_name($chat_with_id,$chat_with_role){


        if ($chat_with_role=='admin') {

            $get_detail = self::getAdmin($chat_with_id);
            return $get_detail->admin_name;
        }
        if ($chat_with_role=='instructor')
        {
            $get_detail =self::getInstructor($chat_with_id);

            return $get_detail->instructor_name;
        }
        if ($chat_with_role=='student')
        {
            $get_detail = self::getStudent($chat_with_id);

            return $get_detail->std_name;
        }
        if ($chat_with_role=='qa_officer')
        {
            $get_detail = self::getQA($chat_with_id);

            return $get_detail->qa_name;
        }
        if ($chat_with_role=='program_coordinator')
        {
            $get_detail = self::getProgramCo($chat_with_id);

            return $get_detail->program_co_name;
        }


        return false;
    }
    static function getAdmin($id)
    {
        $result = Admin::where(['admin_id'=>$id])->first();

        return  $result;

    }

    static function getInstructor($id)
    {
        $result = Instructor::where(['instructor_id'=>$id])->first();

        return  $result;

    }
    static function getQA($id)
    {
        $result = QaOfficer::where(['qa_id'=>$id])->first();

        return  $result;

    }
    static function getProgramCo($id)
    {
        $result = PgCoordinator::where(['program_co_id'=>$id])->first();

        return  $result;

    }
    static function getStudent($id)
    {
        $result = Student::where(['std_id'=>$id])->first();

        return  $result;

    }
    static function getRoleFullText($role)
    {
        if($role=='admin')
        {
            $name='Admin';

        }
        else   if($role == 'instructor')
        {

            $name='Instructor';
        }
        else   if ($role=='student')
        {

            $name='Student';
        }
        else   if ($role=='qa_officer')
        {
            $name='QA Officer';

        }

        else   if ($role=='program_coordinator')
        {
            $name='Program Coordinator';

        }
        return $name;

    }
    static function getAdminsForChat($id)
    {
        $result = Admin::where('admin_id','!=',$id)->get();
         return $result;
    }
    static function getAdmins()
    {
        $result = Admin::get();
        return $result;
    }
    static function getInstructorsForChat($id)
    {
        $result = Instructor::where('instructor_id','!=',$id)->get();
        return $result;
    }
    static function getInstructors()
    {
        $result = Instructor::get();
        return $result;
    }

    static function getStudentsForChat($id)
    {
        $result = Student::where('std_id','!=',$id)->get();
        return $result;
    }
    static function getStudents()
    {
        $result = Student::get();
        return $result;
    }

    static function getQAsForChat($id)
    {
        $result = QaOfficer::where('qa_id','!=',$id)->get();
        return $result;
    }
    static function getQAs()
    {
        $result = QaOfficer::get();
        return $result;
    }

    static function getPGsForChat($id)
    {
        $result = PgCoordinator::where('program_co_id','!=',$id)->get();
        return $result;
    }
    static function getPGs()
    {
        $result = PgCoordinator::get();
        return $result;
    }

   static function get_particular_chat($chat_with_id,$chat_with_role,$chat_from_id,$chat_from_role){

       $chat_from_user_id=Auth::user()->role_tbl_id;
       $login_user_role=Auth::user()->role;
       $chats_results = Chat::where(['chat_from_user_id'=>$chat_from_id,'chat_from_user_role'=>$chat_from_role,'chat_to_user_id'=>$chat_with_id,'chat_to_user_role'=>$chat_with_role])
           ->orWhere(['chat_from_user_id'=>$chat_with_id,'chat_from_user_role'=>$chat_with_role,'chat_to_user_id'=>$chat_from_id,'chat_to_user_role'=>$chat_from_role])->orderBy('chat_id', 'asc')->get();



        $chats = [];
        $count=0;
        if(count($chats_results)>0)
        {
            $chats_results=$chats_results->toArray();
           foreach ($chats_results as $chat){
                if($chat['chat_from_user_id']==$chat_from_user_id  && $chat['chat_from_user_role']==$login_user_role )
                {
                    $chats[$count]['flag'] ="message outgoing";

                }
                else
                {
                    $chats[$count]['flag'] ="message incoming";

                }

                $chats[$count]['chat_message'] = $chat['chat_message'];
                $chats[$count]['chat_date'] = $chat['chat_date_time'];

                $count++;
            }
        }

//    print_r($chats);
//    exit();
        return $chats;

    }
    static function get_n_courses() {

        return Course::select('course_id')->get()->count();


    }

    static function get_student_activities() {


        $activities=StudentActivity::get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }
        return $activities;
    }

    static function get_instructor_activities() {


        $activities=InstructorActivity::get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }
        return $activities;
    }

    static function get_qa_activities() {


        $activities=QaOfficerActivity::get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }
        return $activities;
    }
    static function get_pc_activities() {


        $activities=PgCoordinatorActivity::get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }
        return $activities;
    }
        static function get_specifc_student_activities($std_id) {
            $activities=StudentActivity::where(['std_id'=>$std_id])->get();
            if(count($activities)>0)
            {
                $activities=$activities->toArray();
            }

            return $activities;
        }
    static function get_specifc_ins_activities($ins_id) {
        $activities=InstructorActivity::where(['ins_id'=>$ins_id])->get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }

        return $activities;
    }
    static function get_specifc_qa_activities($ins_id) {
        $activities=QaOfficerActivity::where(['qa_id'=>$ins_id])->get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }

        return $activities;
    }
    static function get_specifc_pg_activities($id) {
        $activities=PgCoordinatorActivity::where(['pc_id'=>$id])->get();
        if(count($activities)>0)
        {
            $activities=$activities->toArray();
        }

        return $activities;
    }
        static function sendWelcomeMail($name,$id,$email,$regNumber,$password)
        {
            $url = "https://vxk1010.uta.cloud/home.php?user_identity={$id}";

            $message ="<html>
                            <head>
                            <title>Welcome ".$name."</title>
                            </head>
                            <body>
                            <p>Welcome to Schoolify!</p>
                            <p>Click the link below to activate your account. Login with the credentials.</p>
                            <p>Regiestration ID  ".$regNumber." and Password  ".$password."</p>
                            <p><a href='{$url}'>{$url}</a></p>
                            </body>
                            </html>";
            $data = [
                'title' => 'Dear '.$name,
                'body' => $message,
            ];

            Mail::to($email)->send(new DemoEmail($data));

        }


    static function getSpecificPermission($typeId)
    {
        $per=Permissions::where(['permission_allow'=>$typeId])->get();
        if(count($per)>0)
        {
            $per=$per->toArray();
        }

        return $per;

    }
   static  function getInstructorPermission($id)
    {
        $per=InstructorPermissions::where(['instructor_id'=>$id])->get();
        if(count($per)>0)
        {
            $per=$per->toArray();
        }

        return $per;

    }
    static  function getQaPermission($id)
    {
        $per=QaPermissions::where(['qa_id'=>$id])->get();
        if(count($per)>0)
        {
            $per=$per->toArray();
        }

        return $per;

    }
    static  function getPgPermission($id)
    {
        $per=PgPermissions::where(['program_co_id'=>$id])->get();
        if(count($per)>0)
        {
            $per=$per->toArray();
        }

        return $per;

    }

   static  function insertIntoPCActivities($pc_activity, $pc_id) {
        $time_stamp = date("Y-m-d H:i:s");
        PgCoordinatorActivity::create([
            'pc_activity' => $pc_activity,
            'pc_id' => $pc_id,
            'time_stamp' => $time_stamp
        ]);
    }
    static function insertIntoInstructorActivities($ins_activity, $ins_id) {
        $time_stamp = date("Y-m-d H:i:s");
        InstructorActivity::create([
            'ins_activity' => $ins_activity,
            'ins_id' => $ins_id,
            'time_stamp' => $time_stamp
        ]);

    }
    static function get_curriculums()
    {
        $curr=Curriculum::get();
        if(count($curr)>0)
        {
            $curr=$curr->toArray();
        }

        return $curr;

    }

    static function get_teacher_courses($ins_id) {

        $courses = Course::where(['teacher_id'=>$ins_id])->get();


        return $courses;
    }
    static function get_all_courses() {

        $courses = Course::get();


        return $courses;
    }
    static function get_teacher_exams($ins_id) {
        $exams = Exam::where(['teacher_id'=>$ins_id,'is_deleted'=>0])->get();



        return $exams;
    }
    static function get_course_students($course_id) {
        $students = StudentCourse::where(['course_id'=>$course_id])->get();



        return $students;
    }
    static function get_student_results($std_id,$course_id) {
        $get_exams =self ::get_course_exams($course_id);
        $total_marks=0;
        $marks_obtained=0;
        $percentage=0;
        $results = array();

        if(count($get_exams)>0) {
            $count=0;
            foreach ($get_exams as $each_exam) {

                $exam_id = $each_exam->exam_id;

                $result = StudentExam::where(['exam_id'=>$exam_id,'std_id'=>$std_id])->first();;


                if (!empty($result)) {
                    $count++;
                    $result = $result->toArray();

                    $total_marks += $each_exam->exam_total_marks;
                    $marks_obtained += $result['marks_obtained'];
                    $percentage = self:: getPercentage($marks_obtained, $total_marks);

                }

            }

            if($count==0)
            {
                $results['message']='No exam given by this student';
            }
            else
            {
                $results['total_marks'] = $total_marks;
                $results['obtained_marks'] = $marks_obtained;
                $results['percentage'] = $percentage;
                $results['message']='';
            }
//        print_r($results);
//        exit;
        }
        else
        {
            $results['message']='No exam given by this student';

        }

        return $results;
    }
    static function get_student_all_exams($std_id,$course_id) {
        $get_exams =self::get_course_exams($course_id);
        $total_marks=0;
        $marks_obtained=0;
        $percentage=0;
        $results = array();

        if(count($get_exams)>0) {
            $count=0;
            foreach ($get_exams as $each_exam) {

                $exam_id = $each_exam->exam_id;
                $exam_title= $each_exam->exam_title;


                $result = StudentExam::where(['exam_id'=>$exam_id,'std_id'=>$std_id])->first();



                if (!empty($result)) {
                    $count++;
                    $result = $result->toArray();

                    $total_marks =$each_exam['exam_total_marks'];
                    $marks_obtained =$result['marks_obtained'];
                    $percentage = self::getPercentage($marks_obtained, $total_marks);

                    $results[$count]['topic'] = $exam_title;
                    $results[$count]['total_marks'] = $total_marks;
                    $results[$count]['obtained_marks'] = $marks_obtained;
                    $results[$count]['percentage'] = $percentage;
                    $results[$count]['remark'] = $result['remarks'];

                    $count++;
                }

            }




//        print_r($results);
//        exit;
        }
        else
        {
            $results['message']='No exam given by this student';

        }

        return $results;
    }
    static function get_student_exams($exam_id) {
        $student_details= StudentExam::where(['exam_id'=>$exam_id])->get();;

        return $student_details;
    }

    static function get_question_details($exam_id) {
        $question_details = ExamQuestionare::where(['exam_id'=>$exam_id])->get();

        return $question_details;
    }
   static  function getExamQuestions($exam_id) {

        $exam_questions = ExamQuestionare::where(['exam_id'=>$exam_id])->get();
        if (count($exam_questions) > 0) {
            $questions = [];
            foreach ($exam_questions as $row) {
                $question = [
                    "id" => $row['quest_id'],
                    "question" => $row['question'],
                    "options" => [
                        $row['option_1'],
                        $row['option_2']
                    ], // Assuming options are stored as comma-separated values
                ];
                $questions[] = $question;
            }
//        print_r($questions);
//        exit;
            return $questions;
        } else {
            return false;
        }


        return $questions;
    }
    static function processAnswers($postData) {
        $submittedAnswers = [];

        foreach ($postData as $key => $value) {
            // Check if the key starts with "mcq" (assuming these are your answer keys)
            if (strpos($key, 'mcq') === 0) {
                $questionId = str_replace('mcq', '', $key);
                $submittedAnswers[$questionId] = $value;
            }
        }

        // Return a response (modify this part based on your logic)
        return $submittedAnswers;
    }
    static function getPolicies($id)
    {
        $retrievePolicies=Policy::where(['qa_id'=>$id])->get();
        if(count($retrievePolicies)>0)
        {
            $retrievePolicies=$retrievePolicies->toArray();
        }
        return $retrievePolicies;

    }

    static function getRecommendations($id)
    {
        $retrieveRecommendations=Recomendation::where(['qa_id'=>$id])->get();
        if(count($retrieveRecommendations)>0)
        {
            $retrieveRecommendations=$retrieveRecommendations->toArray();
        }
        return $retrieveRecommendations;

    }

    static function getStudentPerformances()
    {
        return false;
//        if(isset( $_POST['student_id']) == false || isset( $_POST['course_id']) == false){
//            return false;
//        }
//        $std_id = mysqli_real_escape_string($db, $_POST['student_id']);
//        $course_id = mysqli_real_escape_string($db, $_POST['course_id']);
//        $marksArray = array();
//        $exams_ids = "SELECT exam_id FROM exams WHERE course_id = '$course_id'";
//        $exams_ids_result = mysqli_query($db, $exams_ids);
//        if ($exams_ids_result) {
//            while ($row = mysqli_fetch_assoc($exams_ids_result)) {
//                $exam_id = $row['exam_id'];
//                $std_exam_ids = "SELECT * FROM student_exam WHERE std_id = '$std_id' AND exam_id = '$exam_id' ";
//                $std_exam_ids_result = mysqli_query($db, $std_exam_ids);
//                $inner_row = mysqli_fetch_assoc($std_exam_ids_result);
//                if(empty($inner_row))
//                {
//                    $student_marks_obtained =0;
//                }
//                else
//                {
//                    $student_marks_obtained =$inner_row['marks_obtained'];
//                }
////
////            print_r($inner_row);
////            exit();
//                $sql = "SELECT AVG(marks_obtained) AS average_marks_obtained FROM student_exam WHERE exam_id = '$exam_id'";
//                $average_marks_result = mysqli_query($db, $sql);
//                $average_marks_obtained = 5; // Set a default value
//
//                if ($average_marks_result) {
//                    $average_marks_row = mysqli_fetch_assoc($average_marks_result);
//
//                    if ($average_marks_row !== false && isset($average_marks_row['average_marks_obtained'])) {
//                        // Access the "average_marks_obtained" safely
//                        $average_marks_obtained = $average_marks_row['average_marks_obtained'];
//                    }
//                } else {
//                    echo "Error: Query for 'average_marks_obtained' failed.";
//                    exit();
//                }
//
//                $inner_array = array($student_marks_obtained, $average_marks_obtained);
//
//                array_push($marksArray, $inner_array);
//            }
////                    print_r($marksArray);
////            exit();
////        exit();
//            return $marksArray;
//        } else {
//            return false;
//        }
    }

     static  function getStudentCourses($std_id){

        $result = StudentCourse::where(['std_id'=>$std_id])->orderBy('course_id', 'asc')->get();
        return $result;
    }
     static function getCurrentSemesterByStudent($admissionYear) {
        // Assume a typical academic year with two semesters: Fall and Spring
        // Replace this with your specific logic to determine the current semester
        $currentYear = date('Y');
        $currentMonth = date('n');

        if ($currentMonth >= 1 && $currentMonth <= 6) {
            // Spring semester
            return ($currentYear - $admissionYear) * 2 + 2;
        } else {
            // Fall semester
            return ($currentYear - $admissionYear) * 2 + 1;
        }
    }
}
