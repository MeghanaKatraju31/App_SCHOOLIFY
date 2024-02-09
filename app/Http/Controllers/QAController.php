<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Policy;
use App\Models\Recomendation;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QAController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $instructors = CommonFunctions:: getInstructors();
        $students = CommonFunctions::getStudents();

        $numberOfInstructors = count($instructors);
        $numberOfStudents = count($students);
        $numberOfcourses = CommonFunctions::get_n_courses();
        return view('qa_officer.qaPortal', compact('numberOfcourses', 'numberOfInstructors', 'numberOfStudents'));

    }
    public function policyIndex()
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $policies= CommonFunctions::getPolicies($qa['qa_id']);

        return view('qa_officer.policy.index', compact('policies'));

    }

    public function createPolicy()
    {


        $update = false;

        return view('qa_officer.policy.add_edit', compact('update'));
    }
    public function editPolicy( Request $request)
    {

        $data= Policy::where(['policy_id'=>$request->id])->first();

        $update = true;

        return view('qa_officer.policy.add_edit', compact('update','data'));
    }

    public function submitPolicy(Request $request)
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $qa_id= $qa['qa_id'];
        $policyType = $request->policyType;
        $policyDesc = $request->policyDescription;
        $policyTitle = $request->policyTitle;
        $qa_id = $qa_id;
        $lastUpdated = date("Y-m-d H:i:s");
        Policy::create([
            'policy_type'=>$policyType,
            'policy_desc'=>$policyDesc,
            'policy_title'=>$policyTitle,
            'qa_id'=>$qa_id,
            'last_updated'=>$lastUpdated,
        ]);

        return redirect('/qa-policies');
    }

    public function updatePolicy(Request $request)
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $qa_id= $qa['qa_id'];
        $policyType = $request->policyType;
        $policyDesc = $request->policyDescription;
        $policyTitle = $request->policyTitle;
        $lastUpdated = date("Y-m-d H:i:s");
        Policy::where(['policy_id' => $request->policy_id])->update([
            'policy_type'=>$policyType,
            'policy_desc'=>$policyDesc,
            'policy_title'=>$policyTitle,
            'qa_id'=>$qa_id,
            'last_updated'=>$lastUpdated,
        ]);

        return redirect('/qa-policies');
    }
    public function viewPolicy( Request $request)
    {

        $policy= Policy::where(['policy_id'=>$request->id])->first();


        return view('qa_officer.policy.view', compact('policy'));
    }
    public function deletePolicy( Request $request)
    {

        Policy::where(['policy_id' => $request->id])->delete();



        return redirect('/qa-policies');
    }



    public function recomendationIndex()
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $recomendation= CommonFunctions::getRecommendations($qa['qa_id']);

        return view('qa_officer.recomendation.index', compact('recomendation'));

    }

    public function createRecomendation()
    {


        $update = false;

        return view('qa_officer.recomendation.add_edit', compact('update'));
    }
    public function editRecomendation( Request $request)
    {

        $data= Recomendation::where(['recommendation_id'=>$request->id])->first();

        $update = true;

        return view('qa_officer.recomendation.add_edit', compact('update','data'));
    }

    public function submitRecomendation(Request $request)
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $recommendationTitle = $request->recommendationTitle;
        $recommendationType = $request->recommendationType;
        $recommendationDescription = $request->recommendationDescription;
        $lastUpdated = date("Y-m-d H:i:s");

        $qa_id= $qa['qa_id'];

        Recomendation::create([
            'recommendation_title'=>$recommendationTitle,
            'related_to'=>$recommendationType,
            'recommedation_desc'=>$recommendationDescription,
            'qa_id'=>$qa_id,
            'last_updated'=>$lastUpdated,
        ]);

        return redirect('/qa-recomendations');
    }

    public function updateRecomendation(Request $request)
    {
        $qa = CommonFunctions::get_qa(Auth::user()->user_id);
        $recommendationTitle = $request->recommendationTitle;
        $recommendationType = $request->recommendationType;
        $recommendationDescription = $request->recommendationDescription;
        $lastUpdated = date("Y-m-d H:i:s");

        $qa_id= $qa['qa_id'];

        Recomendation::where(['recommendation_id' => $request->recommendation_id])->update([
            'recommendation_title'=>$recommendationTitle,
            'related_to'=>$recommendationType,
            'recommedation_desc'=>$recommendationDescription,
            'qa_id'=>$qa_id,
            'last_updated'=>$lastUpdated,
        ]);

        return redirect('/qa-recomendations');

    }
    public function viewRecomendation( Request $request)
    {

        $recommendation= Recomendation::where(['recommendation_id'=>$request->id])->first();


        return view('qa_officer.recomendation.view', compact('recommendation'));
    }
    public function deleteRecomendation( Request $request)
    {

        Recomendation::where(['recommendation_id' => $request->id])->delete();



        return redirect('/qa-recomendations');
    }
    public function studentPerformance( Request $request)
    {

        $students=CommonFunctions::getStudents();

        $data = CommonFunctions::getStudentPerformances();


        return view('qa_officer.studentPerformance', compact('students','data'));
    }
    public  function getStudentCourses(Request $request)
    {

        $student_id =$request->student_id;
        $result = CommonFunctions::getStudentCourses($student_id);
        if (count($result)>0) {
                echo '<option value="" selected>Select Course</option>';
                foreach ($result as $row) {
                    $course_id = $row['course_id'];
                    $course_name_result = CommonFunctions::get_course_details($course_id);
                    $course_name = $course_name_result->course_title;
                    echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                }

        } else {
            echo '<option value="">No courses found</option>';
        }
    }

    public  function chartData(Request $request)
    {


        $std_id = $request->student_id;
        $course_id = $request->course_id;

        $marksArray = array();

        $exams_ids_result = Exam::where(['course_id'=>$course_id])->get();

        if (count($exams_ids_result)>0) {
            foreach ($exams_ids_result as $row) {
                $exam_id = $row->exam_id;
                $std_exam_ids_result = StudentExam::where(['std_id'=>$std_id,'exam_id'=>$exam_id])->first();
                $inner_row = $std_exam_ids_result;
                if(empty($inner_row))
                {
                    $student_marks_obtained =0;
                }
                else
                {
                    $student_marks_obtained =$inner_row->marks_obtained;
                }
//
//            print_r($inner_row);
//            exit();
                $average_marks_result = StudentExam::where('exam_id', $exam_id)
                    ->selectRaw('AVG(marks_obtained) as average_marks_obtained')
                    ->first();

                // Access the average marks obtained
                $average_marks_obtained = 5; // Set a default value

                if (!empty($average_marks_result)) {


                        // Access the "average_marks_obtained" safely
                        $average_marks_obtained = $average_marks_result->average_marks_obtained;

                }

                $inner_array = array($student_marks_obtained, $average_marks_obtained);

                array_push($marksArray, $inner_array);
            }
//                    print_r($marksArray);
//            exit();
//        exit();
        }
        return response()->json([
            'values' => $marksArray,
        ]);
    }

}
