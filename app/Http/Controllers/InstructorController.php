<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\Exam;
use App\Models\ExamQuestionare;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
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
        return view('instructor.instructorPortal', compact('numberOfcourses', 'numberOfInstructors', 'numberOfStudents'));
    }
    public function examIndex()
    {

        return view('instructor.exam.index');
    }

    public function results()
    {

        return view('instructor.result');
    }
    public function viewResult(Request $request)
    {
        $std_id=$request->std_id;
        $course_id= $request->course_id;
        $get_course_detail = CommonFunctions:: get_course_details($course_id);
        $student_detail= CommonFunctions::getStudent($std_id);
        $exams = CommonFunctions:: get_student_all_exams($std_id, $course_id);
        return view('instructor.viewResult',compact('get_course_detail','student_detail','exams'));
    }
    public function viewGrade(Request $request)
    {
        $exam_id= $request->exam_id;
        $exam_det =CommonFunctions:: get_exam_details($exam_id);

        return view('instructor.exam.viewGrade',compact('exam_det',));
    }
    public function courseDetail(Request $request)
    {

        $course_id = $request->course_id;
        $course_det=CommonFunctions::get_course_details($course_id);
        $content_dets=CommonFunctions::get_content_details($course_id);
//        echo $course_id;
//        exit;
        return view('instructor.instructorCoursePage',compact('course_det','content_dets'));
    }
    public function createExam(Request $request)
    {

        $instructor = CommonFunctions::get_instructor(Auth::user()->user_id);
        $teacher_id=$instructor['instructor_id'];
        $courses=CommonFunctions::get_teacher_courses($teacher_id);
//        echo $course_id;
//        exit;
        return view('instructor.exam.add',compact('courses','teacher_id'));
    }

    public function submitExam(Request $request)
    {

//        print_r($_POST);
//        exit;
//        echo 'hello';
//        exit;
        // Extract and sanitize data from the form
        $exam_title = $request->exam_title;
        $exam_desc= $request->exam_desc;
        $due_date = $request->due_date;
        $time_allot = $request->time_alloted;
        $course = $request->course_id; // Replace with your method of obtaining the exam_id
        $teacher = $request->teacher_id;
        // Update the exam details in the 'exams' table

        $exam = Exam::create([

            'exam_title' => $exam_title,
            'exam_desc' => $exam_desc,
            'exam_due_date' => $due_date,
            'time_alloted' => $time_allot,
            'exam_total_marks' => '10',
            'teacher_id' => $teacher,
            'course_id' => $course,


        ]);


            $exam_id = $exam->exam_id;
            // Assuming you have a way to fetch and update questions and options
                $questions = $request->question;
//            echo count($questions);
//            exit;
                $options1 = $request->option1;
                $options2 = $request->option2;
                $correctoption = $request->correctoption;

                $count=1;
                for ($i = 0; $i < count($questions); $i++) {


                    $question = $questions[$i];
                    $option1 =$options1[$i];
                    $option2 = $options2[$i];
                    $correct_options =  $correctoption[$count];



                    $correct_option='';
                    if($correct_options=='c_option1')
                    {
                        $correct_option = $option1;
                    }
                    elseif($correct_options=='c_option2')
                    {
                        $correct_option = $option2;
                    }


                    $exam_ques = ExamQuestionare::create([

                        'question' => $question,
                        'option_1' => $option1,
                        'option_2' => $option2,
                        'correct_option' => $correct_option,
                        'exam_id' => $exam_id,



                    ]);



                    $count++;
                }
//            exit;
                CommonFunctions::insertIntoInstructorActivities("Exam is created.", $teacher);

        return redirect('/instructor-exams');    }

    public function editExam(Request $request)
    {
        $exam_id = $request->exam_id;
        $exam_det =CommonFunctions:: get_exam_details($exam_id);
        $exam_question=CommonFunctions::get_question_details($exam_id);


        return view('instructor.exam.edit',compact('exam_id','exam_det','exam_question'));
    }

    public function updateExam(Request $request)
    {

//        print_r($_POST);
//        exit;
//        echo 'hello';
//        exit;
        // Extract and sanitize data from the form
        $exam_id = $request->exam_id;
        $exam_title = $request->exam_title;

        $time_allot = $request->time_allot;
        $teacher = $request->teacher_id;
        // Update the exam details in the 'exams' table



        $exam = Exam::where(['exam_id' => $exam_id])->update([

            'exam_title' => $exam_title,

            'time_alloted' => $time_allot,



        ]);
        ExamQuestionare::where(['exam_id' => $exam_id])->delete();

        // Assuming you have a way to fetch and update questions and options
        $questions = $request->question;
//            echo count($questions);
//            exit;
        $options1 = $request->option1;
        $options2 = $request->option2;
        $correctoption = $request->correctoption;

        $count=1;
        for ($i = 0; $i < count($questions); $i++) {


            $question = $questions[$i];
            $option1 =$options1[$i];
            $option2 = $options2[$i];
            $correct_options =  $correctoption[$count];



            $correct_option='';
            if($correct_options=='c_option1')
            {
                $correct_option = $option1;
            }
            elseif($correct_options=='c_option2')
            {
                $correct_option = $option2;
            }


            $exam_ques = ExamQuestionare::create([

                'question' => $question,
                'option_1' => $option1,
                'option_2' => $option2,
                'correct_option' => $correct_option,
                'exam_id' => $exam_id,



            ]);



            $count++;
        }
//            exit;
        CommonFunctions::insertIntoInstructorActivities("Exam is updated.", $teacher);

        return redirect('/instructor-exams');    }

    public function viewExam(Request $request)
    {
        $exam_id = $request->exam_id;
        $exam_det =CommonFunctions:: get_exam_details($exam_id);
        $exam_question=CommonFunctions::get_question_details($exam_id);


        return view('instructor.exam.view',compact('exam_id','exam_det','exam_question'));
    }
    public function deleteExam(Request $request)
    {
        $exam_id = $request->exam_id;
        StudentExam::where(['exam_id' => $exam_id])->delete();


        ExamQuestionare::where(['exam_id' => $exam_id])->delete();
        Exam::where(['exam_id' => $exam_id])->delete();



        return redirect('/instructor-exams');     }
    public function viewPending(Request $request)
    {
        $exam_id= $request->exam_id;
        $exam_det =CommonFunctions:: get_exam_details($exam_id);
        return view('instructor.exam.viewPending',compact('exam_det',));
    }
    public function provideRemarks(Request $request)
    {
        $exam_id= $request->exam_id;
        $exam_det =CommonFunctions:: get_exam_details($exam_id);
        $questin_details=CommonFunctions::get_question_details($exam_id);
        $student_det = CommonFunctions::getStudent($request->std_id);

        $student_exam_details=CommonFunctions::get_studentexam_details($exam_id,$request->std_id);
        $std_id=$request->std_id;
        return view('instructor.exam.provideRemarks',compact('exam_det','exam_id','std_id','questin_details','student_det','student_exam_details'));
    }
    public function submitRemarks(Request $request)
    {
        $exam_id= $request->exam_id;
        $std_id =$request->std_id ;
        $remarks = $request->remarks;


        // Update student_exam table

        $exam = StudentExam::where(['exam_id' => $exam_id,'std_id'=>$std_id])->update([

            'remarks' => $remarks,

            'is_graded' => 1,



        ]);
        // Access the total students count and graded students count
        $result=StudentExam::where('exam_id', $exam_id)
            ->selectRaw('COUNT(*) as total_students, SUM(is_graded) as graded_students')
            ->first();
        $totalStudents = $result->total_students;
        $gradedStudents = $result->graded_students;

            if ($totalStudents ==$gradedStudents) {
                // If all students are graded, mark the exam as graded
                Exam::where(['exam_id' => $exam_id])->update([



                    'is_graded' => 1,



                ]);

            }

        return redirect('/instructor-exams');
    }
}
