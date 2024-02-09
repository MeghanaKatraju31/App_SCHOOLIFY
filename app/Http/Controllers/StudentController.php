<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\ExamQuestionare;
use App\Models\StudentExam;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('student.studentPortal');
    }

    public function studentCourseDetail(Request $request)
    {

        $course_id = $request->course_id;
        $course_det=CommonFunctions::get_course_details($course_id);
        $content_dets=CommonFunctions::get_content_details($course_id);
//        echo $course_id;
//        exit;
        return view('student.studentCoursePage',compact('course_det','content_dets'));
    }
    public function studentCourses(Request $request)
    {


        return view('student.studentCourses');
    }

    public function studentExams(Request $request)
    {

        $student = CommonFunctions::get_student(Auth::user()->user_id);
        $admission_year=$student['std_admission_year'];
        $std_id=$student['std_id'];


        $currentSemester = CommonFunctions::getCurrentSemester($admission_year);
        $courses = CommonFunctions::get_student_courses($std_id, $currentSemester);
        return view('student.studentExams',compact('courses','std_id'));
    }

    public function studentResults(Request $request)
    {

        $student = CommonFunctions::get_student(Auth::user()->user_id);
        $admission_year=$student['std_admission_year'];
        $std_id=$student['std_id'];


        $currentSemester = CommonFunctions::getCurrentSemester($admission_year);

        $results = array();
        $count_sem=0;
        for ($semester = $currentSemester; $semester >= 1; $semester--) {

            $semesterType = $semester % 2 === 0 ? 'SPRING' : 'FALL';
            $results[$count_sem]['type']=$semesterType;
            $results[$count_sem]['number']=$semester;
            $student_courses = CommonFunctions::get_student_courses($std_id, $semester);
            if (!empty($student_courses)) {

                $overall_percentage_sum = 0;
                $total_courses = count($student_courses);
                $count_course=0;
                foreach ($student_courses as $student_course) {
                    $course_det = CommonFunctions::get_course_details($student_course->course_id);
                    $results[$count_sem]['courses'][$count_course]['title']=$course_det->course_title;
                    $exams = CommonFunctions::get_course_exams($student_course->course_id); // Get all exams for the course


                    $totalMarks = 0;

                    $total_obtained_marks = 0;
                    $exam_count=0;
                    $count_exam=0;
                    $get_max_count = CommonFunctions::get_maximum_test($std_id,$semester);
                    if(count($exams)>0) {

                        foreach ($exams as $exam) {
                            $exam_count++;
                            $exam_det = CommonFunctions::get_exam_details($exam['exam_id']);
                            $student_exam_details = CommonFunctions::get_studentexam_details_grade($exam_det['exam_id'], $std_id);


                            if (!empty($student_exam_details)) {


                                $totalMarks += $exam['exam_total_marks'];
                                // Add the marks to the respective assessment
                                $assessmentNumber = $exam['marks_obtained'] ;

                                $assessmentMarks = $student_exam_details['marks_obtained'];
                                $total_obtained_marks += $assessmentMarks;
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_total_marks']=$exam['exam_total_marks'];
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_obtained_marks']=$assessmentMarks;

                                $count_exam++;
                            }
                            else
                            {
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_total_marks']=0;
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_obtained_marks']=0;
                                $count_exam++;
                            }

                        }
                        if($get_max_count-$exam_count!=0)
                        {
                            for ($i=0 ;$i<$get_max_count-$exam_count;$i++)
                            {
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_total_marks']=0;
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_obtained_marks']=0;
                                $count_exam++;
                            }
                        }
                    }
                    else
                    {

                        if($get_max_count!=0)
                        {


                            for($i=0;$i<$get_max_count;$i++)
                            {
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_total_marks']=0;
                                $results[$count_sem]['courses'][$count_course]['exams'][$count_exam]['exam_obtained_marks']=0;
                                $count_exam++;
                            }
                        }
                    }

                    if($totalMarks==0)
                    {
                        $results[$count_sem]['courses'][$count_course]['percentage']=0;
                     $overall_percentage_sum+=0;
                    }
                    else
                    {
                        $results[$count_sem]['courses'][$count_course]['percentage']=CommonFunctions:: getPercentage($total_obtained_marks,$totalMarks);
                        $overall_percentage_sum+=CommonFunctions:: getPercentage($total_obtained_marks,$totalMarks);
                    }

                    $count_course++;
                }
            }
            $overall_percentage= $overall_percentage_sum/$total_courses;
            if ($overall_percentage == (int)$overall_percentage) {
                $overall_percentage = (int)$overall_percentage ;
            } else {
                // Format as percentage with two decimal places
                $overall_percentage = number_format($overall_percentage, 2);
            }


            if($overall_percentage>0)
            {
                $overall_percentage.= '%';
            }
            $results[$count_sem]['overall_perc']=$overall_percentage;
            $count_sem++;
        }
//        echo "<pre>";
//        print_r($results);
//        exit;
        return view('student.studentResults',compact('results','std_id','currentSemester'));
    }
    public function takeExam(Request $request)
    {

        $exam_id = $request->exam_id;
        $get_exam_detail= CommonFunctions:: get_exam_details($exam_id);
        $student = CommonFunctions::get_student(Auth::user()->user_id);
        $std_id=$student['std_id'];
        return view('student.takeExam',compact('get_exam_detail','exam_id','std_id'));
    }
    public function submitExam(Request $request)
    {

////        print_r($request->all());
////        exit;
//        $exam_id = $request->exam_id;
//        $get_exam_detail= CommonFunctions:: get_exam_details($exam_id);
//        $student = CommonFunctions::get_student(Auth::user()->user_id);
//        $std_id=$student['std_id'];
        try {
        $answered_questions = CommonFunctions::processAnswers($request->all());
        $reason= $request->reason;



        $exam_id = $request->exam_id;
        $student_id =$request->student_id;

//        $result =CommonFunctions::takeExam($answered_questions,$exam_id,$student_id,$reason);

        $date = date('Y-m-d');
        $obtained_marks=0;
        foreach($answered_questions as $key =>$value)
        {

            $q_id =$key;
            $correct_answer= $value;
            $exam_questions = ExamQuestionare::where(['exam_id'=>$exam_id,'quest_id'=>$q_id,'correct_option'=>$correct_answer])->get();

            if (count($exam_questions) > 0) {
                $obtained_marks++;
            }
        }
//        return "Failed";

//        return $student_id.','.$exam_id .','.$date.','. $obtained_marks.','. $reason;
         StudentExam::create([

            'std_id' => $student_id,
            'exam_id' => $exam_id,
            'submitted_date' => $date,
            'marks_obtained' => $obtained_marks,
            'reason' => $reason,


        ]);



            return "Exam submitted successfully";
    } catch (QueryException $e) {
    // If there's an error, catch the QueryException and return the error message
$errorMessage = $e->getMessage();

return $errorMessage;
}


    }

}
