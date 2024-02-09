<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\Curriculum;
use App\Models\ProgramEvaluation;
use Illuminate\Http\Request;

class ProgramCoordinatorController extends Controller
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
        return view('program_coordinator.pgPortal', compact('numberOfcourses', 'numberOfInstructors', 'numberOfStudents'));
    }
    public function programEvaluation()
    {

        return view('program_coordinator.programEval');
    }
    public function submitEvaluation( Request $request)
    {

        $questions = $request->questions;
        $options = $request->options;
        $pc = $request->pc_id;

        // Add error checking for missing data
        if (empty($questions) || empty($options) || empty($pc)) {
            echo "Missing data: Questions, options, or program ID not provided.";
            return false;
        }



        // Insert program evaluation data
        for ($i = 0; $i < count($questions); $i++) {
            $question = $questions[$i];
            $option =  $options[$i];

            // Define the correct SQL query based on your database structure
            ProgramEvaluation::create([
                'pc_id' => $pc,
                'question' => $question,
                'option' => $option
            ]);


        }

        // Insert a record of the curriculum update in 'PCActivities' or your desired table
        $activityInserted = CommonFunctions::insertIntoPCActivities("Curriculum Updated.", $pc);


        return redirect()->back()->with('message',"Submitted successfully");    }


    public function curriculumIndex()
    {

        $currs= CommonFunctions::get_curriculums();
        return view('program_coordinator.curIndex',compact('currs'));
    }
    public function curriculumCreate()
    {

        $update=false;
        return view('program_coordinator.addEditCurr',compact('update'));
    }
    public function curriculumSubmit( Request $request)
    {
        $pc_id = $request->pc_id;
        $currTitle = $request->cr_title;
        $currDescription =$request->cr_description;



        Curriculum::create([

            'cr_title' => $currTitle,
            'cr_description' => $currDescription,
            'pc_id' => $pc_id,


        ]);
        return redirect('/pg-curriculum');
    }
    public function curriculumEdit(Request $request)
    {

        $cur= Curriculum::where(['cr_id'=>$request->id])->first();
        $update=true;
        return view('program_coordinator.addEditCurr',compact('cur','update'));
    }

    public function curriculumUpdate( Request $request)
    {
        $pc_id = $request->pc_id;
        $currTitle = $request->cr_title;
        $currDescription =$request->cr_description;

        $cr_id= $request->cr_id;


        Curriculum::where(['cr_id' => $cr_id])->update([

            'cr_title' => $currTitle,
            'cr_description' => $currDescription,
            'pc_id' => $pc_id,


        ]);
        return redirect('/pg-curriculum');
    }

    public function curriculumView(Request $request)
    {

        $curr= Curriculum::where(['cr_id'=>$request->id])->first();
        $update=true;
        return view('program_coordinator.curView',compact('curr','update'));
    }


}
