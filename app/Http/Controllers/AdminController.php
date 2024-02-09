<?php

namespace App\Http\Controllers;

use App\CentralFiles\CommonFunctions;
use App\Models\Chat;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Exam;
use App\Models\ExamQuestionare;
use App\Models\Instructor;
use App\Models\InstructorActivity;
use App\Models\InstructorPermissions;
use App\Models\PgCoordinator;
use App\Models\PgCoordinatorActivity;
use App\Models\PgPermissions;
use App\Models\QaOfficer;
use App\Models\QaOfficerActivity;
use App\Models\QaPermissions;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentCourse;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;


class AdminController extends Controller
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
        return view('admin.adminPortal', compact('numberOfcourses', 'numberOfInstructors', 'numberOfStudents'));
    }

    public function getStudents()
    {
        $students = CommonFunctions::getStudents();


        if (count($students) > 0) {
            $students = $students->toArray();
        }
        return view('admin.students.index', compact('students',));
    }

    public function createStudent()
    {

        $update = false;

        return view('admin.students.add_edit', compact('update'));
    }

    public function submitStudent(Request $request)
    {

        $name = $request->name;
        $fatherName = $request->fatherName;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $regNumber = $request->regNumber;
        $program = $request->program;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;
        $semester = $request->semester;
        $year = $request->year;

        $image = $request->file('profile-img');
        $is_already_exists = Student::where(['std_reg_no' => $regNumber])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Registration number already exists");

        }
        if (empty($image)) {
            $imageName = '';
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);

        }

        $activation_key = uniqid();

        $user = User::create([
            'reg_id' => $regNumber,
            'password' => Hash::make($password),
            'role' => 'student',
            'activation_key' => $activation_key,
            'name' => $name
        ]);
        $id = $user->user_id;
        $student = Student::create([

            'std_name' => $name,
            'std_father_name' => $fatherName,
            'std_reg_no' => $regNumber,
            'std_identity_no' => $idNumber,
            'std_dept' => $department,
            'std_program' => $program,
            'std_semester' => $semester,
            'std_admission_year' => $year,
            'std_email' => $email,
            'std_phone_no' => $phoneNumber,
            'std_password' => Hash::make($password),
            'std_image' => $imageName,
            'user_id' => $id

        ]);

        User::where(['user_id' => $id])->update([
            'role_tbl_id' => $student->std_id,

        ]);
//        CommonFunctions::sendWelcomeMail($name,$id,$email,$regNumber,$password);
        return redirect('/admin-students');
    }

    public function editStudent(Request $request)
    {


        $user = CommonFunctions::getStudent($request->id);

        $update = true;

        return view('admin.students.add_edit', compact('update', 'user'));
    }

    public function updateStudent(Request $request)
    {


        $std_id = $request->std_id;
        $name = $request->name;
        $fatherName = $request->fatherName;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $regNumber = $request->regNumber;
        $program = $request->program;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;
        $semester = $request->semester;
        $year = $request->year;
        $is_already_exists = Student::where(['std_reg_no' => $regNumber])->where('std_id','!=',$std_id)->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        $image = $request->file('profile-img');
        if (empty($image)) {
            Student::where(['std_id' => $std_id])->update([

                'std_name' => $name,
                'std_father_name' => $fatherName,
                'std_reg_no' => $regNumber,
                'std_identity_no' => $idNumber,
                'std_dept' => $department,
                'std_program' => $program,
                'std_semester' => $semester,
                'std_admission_year' => $year,
                'std_email' => $email,
                'std_phone_no' => $phoneNumber,
                'std_password' => Hash::make($password),

            ]);

        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);
            Student::where(['std_id' => $std_id])->update([

                'std_name' => $name,
                'std_father_name' => $fatherName,
                'std_reg_no' => $regNumber,
                'std_identity_no' => $idNumber,
                'std_dept' => $department,
                'std_program' => $program,
                'std_semester' => $semester,
                'std_admission_year' => $year,
                'std_email' => $email,
                'std_phone_no' => $phoneNumber,
                'std_password' => Hash::make($password),
                'std_image' => $imageName

            ]);

        }


        return redirect('/admin-students/');
    }

    public function viewStudent(Request $request)
    {
        $student = CommonFunctions::getStudent($request->id);


        return view('admin.students.view', compact('student'));
    }

    public function monitorStudent(Request $request)
    {

        $studentActivities = CommonFunctions:: get_specifc_student_activities($request->id);

        return view('admin.students.monitor', compact('studentActivities'));
    }

    public function deleteStudent(Request $request)
    {
        StudentActivity::where(['std_id' => $request->id])->delete();

        Chat::where(['chat_from_user_id' => $request->id, 'chat_from_user_role' => 'student'])
            ->orWhere(['chat_to_user_id' => $request->id, 'chat_to_user_role' => 'student'])->delete();

        StudentExam::where(['std_id' => $request->id])->delete();
        StudentCourse::where(['std_id' => $request->id])->delete();
        Student::where('std_id', '=', $request->id)->delete();
        User::where('user_id', '=', $request->user_id)->delete();


        return redirect('/admin-students/');
    }


    public function getInstructors()
    {
        $instructors = CommonFunctions::getInstructors();


        if (count($instructors) > 0) {
            $instructors = $instructors->toArray();
        }
        return view('admin.instructors.index', compact('instructors'));
    }

    public function createInstructor()
    {


        $update = false;

        return view('admin.instructors.add_edit', compact('update'));
    }

    public function submitInstructor(Request $request)
    {

        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;
        $program = $request->program;
        $designation = $request->designation;


        $image = $request->file('profile-img');
        $is_already_exists = Instructor::where(['employee_id' => $empId])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $imageName = '';
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);

        }

        $activation_key = uniqid();

        $user = User::create([
            'reg_id' => $empId,
            'password' => Hash::make($password),
            'role' => 'instructor',
            'activation_key' => $activation_key,
            'name' => $name
        ]);
        $id = $user->user_id;
        $ins = Instructor::create([
            'instructor_name' => $name,
            'instructor_father_name' => $fatherName,
            'employee_id' => $empId,
            'instructor_identity_no' => $idNumber,
            'instructor_dept' => $department,
            'instructor_program' => $program,
            'instructor_designation' => $designation,
            'instructor_email' => $email,
            'instructor_phone_no' => $phoneNumber,
            'instructor_password' => Hash::make($password),
            'ins_image' => $imageName,
            'user_id' => $id


        ]);

        User::where(['user_id' => $id])->update([
            'role_tbl_id' => $ins->instructor_id,

        ]);
//        CommonFunctions::sendWelcomeMail($name,$id,$email,$regNumber,$password);
        return redirect('/admin-instructors');
    }

    public function editInstructor(Request $request)
    {


        $user = CommonFunctions::getInstructor($request->id);

        $update = true;

        return view('admin.instructors.add_edit', compact('update', 'user'));
    }

    public function updateInstructor(Request $request)
    {


        $ins_id = $request->instructor_id;
        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;
        $program = $request->program;
        $designation = $request->designation;


        $image = $request->file('profile-img');
        $is_already_exists = Instructor::where(['employee_id' => $empId])->where('instructor_id','!=',$ins_id)->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $ins = Instructor::where(['instructor_id' => $ins_id])->update([
                'instructor_name' => $name,
                'instructor_father_name' => $fatherName,
                'employee_id' => $empId,
                'instructor_identity_no' => $idNumber,
                'instructor_dept' => $department,
                'instructor_program' => $program,
                'instructor_designation' => $designation,
                'instructor_email' => $email,
                'instructor_phone_no' => $phoneNumber,
                'instructor_password' => Hash::make($password),


            ]);
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);
            $ins = Instructor::where(['instructor_id' => $ins_id])->update([
                'instructor_name' => $name,
                'instructor_father_name' => $fatherName,
                'employee_id' => $empId,
                'instructor_identity_no' => $idNumber,
                'instructor_dept' => $department,
                'instructor_program' => $program,
                'instructor_designation' => $designation,
                'instructor_email' => $email,
                'instructor_phone_no' => $phoneNumber,
                'instructor_password' => Hash::make($password),
                'ins_image' => $imageName,


            ]);
        }


        return redirect('/admin-instructors/');
    }

    public function viewInstructor(Request $request)
    {
        $instructor = CommonFunctions::getInstructor($request->id);


        return view('admin.instructors.view', compact('instructor'));
    }

    public function monitorInstructor(Request $request)
    {

        $insActivities = CommonFunctions:: get_specifc_ins_activities($request->id);

        return view('admin.instructors.monitor', compact('insActivities'));
    }

    public function deleteInstructor(Request $request)
    {
        InstructorActivity::where(['ins_id' => $request->id])->delete();

        Chat::where(['chat_from_user_id' => $request->id, 'chat_from_user_role' => 'instructor'])
            ->orWhere(['chat_to_user_id' => $request->id, 'chat_to_user_role' => 'instructor'])->delete();

        InstructorPermissions::where(['instructor_id' => $request->id])->delete();
        Exam::where(['teacher_id' => $request->id])->delete();
        Instructor::where('instructor_id', '=', $request->id)->delete();
        User::where('user_id', '=', $request->user_id)->delete();


        return redirect('/admin-instructors/');
    }

    public function permitInstructor(Request $request)
    {
        $instructor = CommonFunctions::getInstructor($request->id);


        $instructorData = $instructor->toArray();

        $allPermissions = CommonFunctions::getSpecificPermission(1);
        $instructorPermissions = CommonFunctions:: getInstructorPermission($request->id);
        $checkedArray[] = "0";
        if ($instructorPermissions) {
            foreach ($instructorPermissions as $row) {
                $checkedArray[] = $row['permission_id'];
            }
        }
        return view('admin.instructors.permission', compact('instructorData', 'allPermissions', 'checkedArray'));
    }

    public function updatePermitInstructor(Request $request)
    {
            $instructor_id = $request->instructor_id;
            $checkboxes = array(
            'View_Courses' => 1,
            'Add/Update/Delete_Courses' => 2,
            'View_Course_Content' => 3,
            'Add/Update/Delete_Course_Content' => 4,
            'View_Results' => 5,
            'Update_Results' => 6
            );
            foreach ($checkboxes as $checkbox_name => $checkbox_value)
            {
            if (isset($_POST[$checkbox_name]))
            {
                $result=  InstructorPermissions::where(['instructor_id'=>$instructor_id,'permission_id'=>$checkbox_value])->get();
            if (count($result) == 0)
            {
                InstructorPermissions::create([
                    'instructor_id'=>$instructor_id,
                    'permission_id'=>$checkbox_value
                ]);

            }
            } else {
                $query = InstructorPermissions::where(['instructor_id'=>$instructor_id,'permission_id'=>$checkbox_value])->delete();
            }
            }
        return redirect('/admin-instructors/');
        }




        //QAS

    public function getQas()
    {
        $qas = CommonFunctions::getQAs();


        if (count($qas) > 0) {
            $instructors = $qas->toArray();
        }
        return view('admin.qa.index', compact('qas'));
    }

    public function createQa()
    {


        $update = false;

        return view('admin.qa.add_edit', compact('update'));
    }

    public function submitQa(Request $request)
    {



        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;


        $image = $request->file('profile-img');
        $is_already_exists = QaOfficer::where(['employee_id' => $empId])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $imageName = '';
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);

        }

        $activation_key = uniqid();

        $user = User::create([
            'reg_id' => $empId,
            'password' => Hash::make($password),
            'role' => 'qa_officer',
            'activation_key' => $activation_key,
            'name' => $name
        ]);
        $id = $user->user_id;

        $qa = QaOfficer::create([
            'qa_name' => $name,
            'qa_father_name' => $fatherName,
            'employee_id' => $empId,
            'qa_identity_no' => $idNumber,
            'qa_dept' => $department,
            'qa_email' => $email,
            'qa_phone_no' => $phoneNumber,
            'qa_password' => Hash::make($password),
            'qa_image' => $imageName,
            'user_id' => $id


        ]);

        User::where(['user_id' => $id])->update([
            'role_tbl_id' => $qa->instructor_id,

        ]);
//        CommonFunctions::sendWelcomeMail($name,$id,$email,$regNumber,$password);
        return redirect('/admin-qas');
    }

    public function editQa(Request $request)
    {


        $user = CommonFunctions::getQA($request->id);

        $update = true;

        return view('admin.qa.add_edit', compact('update', 'user'));
    }



    public function updateQa(Request $request)
    {


        $qa_id=$request->qa_id;
        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;


        $image = $request->file('profile-img');
        $is_already_exists = QaOfficer::where(['employee_id' => $empId])->where('qa_id','!=',$qa_id)->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $ins = QaOfficer::where(['qa_id' => $qa_id])->update([
                'qa_name' => $name,
                'qa_father_name' => $fatherName,
                'employee_id' => $empId,
                'qa_identity_no' => $idNumber,
                'qa_dept' => $department,
                'qa_email' => $email,
                'qa_phone_no' => $phoneNumber,
                'qa_password' => Hash::make($password),



            ]);
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);
            $ins = QaOfficer::where(['qa_id' => $qa_id])->update([
                'qa_name' => $name,
                'qa_father_name' => $fatherName,
                'employee_id' => $empId,
                'qa_identity_no' => $idNumber,
                'qa_dept' => $department,
                'qa_email' => $email,
                'qa_phone_no' => $phoneNumber,
                'qa_password' => Hash::make($password),
                'qa_image' => $imageName,


            ]);
        }


        return redirect('/admin-qas/');
    }

    public function viewQa(Request $request)
    {
        $qa = CommonFunctions::getQA($request->id);


        return view('admin.qa.view', compact('qa'));
    }

    public function monitorQa(Request $request)
    {

        $qaActivities = CommonFunctions:: get_specifc_qa_activities($request->id);

        return view('admin.qa.monitor', compact('qaActivities'));
    }

    public function deleteQa(Request $request)
    {
        QaOfficerActivity::where(['qa_id' => $request->id])->delete();

        Chat::where(['chat_from_user_id' => $request->id, 'chat_from_user_role' => 'qa_officer'])
            ->orWhere(['chat_to_user_id' => $request->id, 'chat_to_user_role' => 'qa_officer'])->delete();

        QaPermissions::where(['qa_id' => $request->id])->delete();
        QaOfficer::where(['qa_id' => $request->id])->delete();

        User::where('user_id', '=', $request->user_id)->delete();


        return redirect('/admin-qas/');
    }

    public function permitQa(Request $request)
    {
        $qa = CommonFunctions::getQA($request->id);


        $qaData = $qa->toArray();

        $allPermissions = CommonFunctions::getSpecificPermission(1);
        $qaPermissions = CommonFunctions:: getQaPermission($request->id);
        $checkedArray[] = "0";
        if ($qaPermissions) {
            foreach ($qaPermissions as $row) {
                $checkedArray[] = $row['permission_id'];
            }
        }
        return view('admin.qa.permission', compact('qaData', 'allPermissions', 'checkedArray'));
    }

    public function updatePermitQa(Request $request)
    {
        $id = $request->qa_id;
        $checkboxes = array(
            'View_Courses' => 1,
            'Add/Update/Delete_Courses' => 2,
            'View_Course_Content' => 3,
            'Add/Update/Delete_Course_Content' => 4,
            'View_Results' => 5,
            'Update_Results' => 6
        );
        foreach ($checkboxes as $checkbox_name => $checkbox_value)
        {
            if (isset($_POST[$checkbox_name]))
            {
                $result=  QaPermissions::where(['qa_id'=>$id,'permission_id'=>$checkbox_value])->get();
                if (count($result) == 0)
                {
                    QaPermissions::create([
                        'qa_id'=>$id,
                        'permission_id'=>$checkbox_value
                    ]);

                }
            } else {
                $query = QaPermissions::where(['qa_id'=>$id,'permission_id'=>$checkbox_value])->delete();
            }
        }
        return redirect('/admin-qas/');
    }


    // PGS

    public function getPgs()
    {
        $programCos = CommonFunctions::getPGs();


        if (count($programCos) > 0) {
            $programCos = $programCos->toArray();
        }
        return view('admin.pg.index', compact('programCos'));
    }

    public function createPg()
    {


        $update = false;

        return view('admin.pg.add_edit', compact('update'));
    }

    public function submitPg(Request $request)
    {



        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;


        $image = $request->file('profile-img');
        $is_already_exists = PgCoordinator::where(['employee_id' => $empId])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $imageName = '';
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);

        }

        $activation_key = uniqid();

        $user = User::create([
            'reg_id' => $empId,
            'password' => Hash::make($password),
            'role' => 'program_coordinator',
            'activation_key' => $activation_key,
            'name' => $name
        ]);
        $id = $user->user_id;

        $pg = PgCoordinator::create([
            'program_co_name' => $name,
            'program_co_father_name' => $fatherName,
            'employee_id' => $empId,
            'program_co_identity_no' => $idNumber,
            'program_co_dept' => $department,
            'program_co_email' => $email,
            'program_co_phone_no' => $phoneNumber,
            'program_co_password' => Hash::make($password),
            'program_co_image' => $imageName,
            'user_id' => $id


        ]);

        User::where(['user_id' => $id])->update([
            'role_tbl_id' => $pg->program_co_id,

        ]);
//        CommonFunctions::sendWelcomeMail($name,$id,$email,$regNumber,$password);
        return redirect('/admin-pgs');
    }

    public function editPg(Request $request)
    {


        $user = CommonFunctions::getProgramCo($request->id);

        $update = true;

        return view('admin.pg.add_edit', compact('update', 'user'));
    }



    public function updatePg(Request $request)
    {


        $pg_id=$request->program_co_id;
        $name = $request->name;
        $fatherName = $request->fatherName;
        $empId = $request->empId;
        $department = $request->department;
        $email = $request->email;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $idNumber = $request->idNumber;


        $image = $request->file('profile-img');
        $is_already_exists = PgCoordinator::where(['employee_id' => $empId])->where('program_co_id','!=',$pg_id)->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Employee ID already exists");

        }
        if (empty($image)) {
            $pg = PgCoordinator::where(['program_co_id' => $pg_id])->update([
                'program_co_name' => $name,
                'program_co_father_name' => $fatherName,
                'employee_id' => $empId,
                'program_co_identity_no' => $idNumber,
                'program_co_dept' => $department,
                'program_co_email' => $email,
                'program_co_phone_no' => $phoneNumber,
                'program_co_password' => Hash::make($password),



            ]);
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('user_images'), $imageName);
            $pg = PgCoordinator::where(['program_co_id' => $pg_id])->update([
                'program_co_name' => $name,
                'program_co_father_name' => $fatherName,
                'employee_id' => $empId,
                'program_co_identity_no' => $idNumber,
                'program_co_dept' => $department,
                'program_co_email' => $email,
                'program_co_phone_no' => $phoneNumber,
                'program_co_password' => Hash::make($password),
                'program_co_image' => $imageName,


            ]);
        }


        return redirect('/admin-pgs/');
    }

    public function viewPg(Request $request)
    {
        $pg = CommonFunctions::getProgramCo($request->id);


        return view('admin.pg.view', compact('pg'));
    }

    public function monitorPg(Request $request)
    {

        $pcActivities = CommonFunctions:: get_specifc_pg_activities($request->id);

        return view('admin.pg.monitor', compact('pcActivities'));
    }

    public function deletePg(Request $request)
    {
        PgCoordinatorActivity::where(['pc_id' => $request->id])->delete();

        Chat::where(['chat_from_user_id' => $request->id, 'chat_from_user_role' => 'program_coordinator'])
            ->orWhere(['chat_to_user_id' => $request->id, 'chat_to_user_role' => 'program_coordinator'])->delete();

        PgPermissions::where(['program_co_id' => $request->id])->delete();
        PgCoordinator::where(['program_co_id' => $request->id])->delete();

        User::where('user_id', '=', $request->user_id)->delete();


        return redirect('/admin-pgs/');
    }

    public function permitPg(Request $request)
    {
        $pg = CommonFunctions::getProgramCo($request->id);


        $programCoData = $pg->toArray();

        $allPermissions = CommonFunctions::getSpecificPermission(1);
        $pgPermissions = CommonFunctions:: getPgPermission($request->id);
        $checkedArray[] = "0";
        if ($pgPermissions) {
            foreach ($pgPermissions as $row) {
                $checkedArray[] = $row['permission_id'];
            }
        }
        return view('admin.pg.permission', compact('programCoData', 'allPermissions', 'checkedArray'));
    }

    public function updatePermitPg(Request $request)
    {
        $id = $request->program_co_id;
        $checkboxes = array(
            'View_Courses' => 1,
            'Add/Update/Delete_Courses' => 2,
            'View_Course_Content' => 3,
            'Add/Update/Delete_Course_Content' => 4,
            'View_Results' => 5,
            'Update_Results' => 6
        );
        foreach ($checkboxes as $checkbox_name => $checkbox_value)
        {
            if (isset($_POST[$checkbox_name]))
            {
                $result=  PgPermissions::where(['program_co_id'=>$id,'permission_id'=>$checkbox_value])->get();
                if (count($result) == 0)
                {
                    PgPermissions::create([
                        'program_co_id'=>$id,
                        'permission_id'=>$checkbox_value
                    ]);

                }
            } else {
                $query = PgPermissions::where(['program_co_id'=>$id,'permission_id'=>$checkbox_value])->delete();
            }
        }
        return redirect('/admin-pgs/');
    }


    //courses
    public function getCourses()
    {
        $courses = CommonFunctions::get_all_courses();



        return view('admin.course.index', compact('courses'));
    }

    public function createCourse()
    {


        $update = false;

        $instructors=CommonFunctions::getInstructors();
        return view('admin.course.add', compact('update','instructors'));
    }

    public function submitCourse(Request $request)
    {


        $courseName = $request->courseName;
        $courseCredits = $request->courseCredits;
        $courseDescription = $request->courseDescription;
        $classesPerWeek = $request->classesPerWeek;
        $classDuration = $request->classDuration;
        $instructor_id = $request->teacher_id;
        $image = $request->file('course_image');

        $is_already_exists = Course::where(['course_title' => $courseName])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "course already exists");

        }
        if (empty($image)) {
            $imageName = '';
        } else {
            $imageName = time() . '.' . $image->extension();

            // Store the image in the public folder
            $image->move(public_path('course_images'), $imageName);

        }
        $course = Course::create([
            'course_title' => $courseName,
            'course_desc' => $courseDescription,
            'credit_hours' => $courseCredits,
            'class_duration' => $classDuration,
            'class_per_week' => $classesPerWeek,
            'course_image' => $imageName,
            'teacher_id' => $instructor_id,



        ]);
        if(!empty($course)) {
            $courseId=$course->course_id;
            $contentTitles = $request->contentTitle;
            $contentDescriptions = $request->contentDescription;
            for ($i = 0; $i < count($contentTitles); $i++) {
                $contentTitle = $contentTitles[$i];
                $contentDescription = $contentDescriptions[$i];
                $course_con = CourseContent::create([
                    'content_title' => $contentTitle,
                    'content_description' => $contentDescription,
                    'course_id' => $courseId,


                ]);
            }

        }



        return redirect('/admin-courses');
    }

    public function editCourse(Request $request)
    {

        $course_id=$request->id;
        $course_det = CommonFunctions::get_course_details($course_id);
        $content_details=CommonFunctions::get_content_details($course_id);
        $update = true;
        $instructors=CommonFunctions::getInstructors();


        return view('admin.course.edit', compact('update', 'course_det','content_details','course_id','instructors'));
    }



    public function updateCourse(Request $request)
    {

        $courseName = $request->courseName;
        $courseCredits = $request->courseCredits;
        $courseDescription = $request->courseDescription;
        $classesPerWeek = $request->classesPerWeek;
        $classDuration = $request->classDuration;
        $instructor_id = $request->teacher_id;
        $course_id = $request->course_id;

        $is_already_exists = Course::where(['course_title' => $courseName])->where('course_id','!=',$course_id)->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "course already exists");

        }
        $course = Course::where(['course_id' => $course_id])->update([
            'course_title' => $courseName,
            'course_desc' => $courseDescription,
            'credit_hours' => $courseCredits,
            'class_duration' => $classDuration,
            'class_per_week' => $classesPerWeek,
            'teacher_id' => $instructor_id,



        ]);
        $delete_query = CourseContent::where(['course_id' => $course_id])->delete();


            $contentTitles = $request->contentTitle;
            $contentDescriptions = $request->contentDescription;
            for ($i = 0; $i < count($contentTitles); $i++) {
                $contentTitle = $contentTitles[$i];
                $contentDescription = $contentDescriptions[$i];
                $course_con = CourseContent::create([
                    'content_title' => $contentTitle,
                    'content_description' => $contentDescription,
                    'course_id' => $course_id,


                ]);
            }




        return redirect('/admin-courses');

    }

    public function viewCourse(Request $request)
    {
        $course_id=$request->id;
        $course_det = CommonFunctions::get_course_details($course_id);
        $content_details=CommonFunctions::get_content_details($course_id);


        return view('admin.course.view', compact('course_det','content_details','course_id'));

    }


    public function deleteCourse(Request $request)
    {
        $course_id=$request->id;
        StudentCourse::where(['course_id' => $request->id])->delete();
        CourseContent::where(['course_id' => $request->id])->delete();
        DB::table('exam_questionnaire')
            ->whereIn('exam_id', function ($query) use ($course_id) {
                $query->select('exam_id')
                    ->from('exams')
                    ->where('course_id', $course_id);
            })
            ->delete();
        Exam::where('course_id', '=', $request->id)->delete();

        Course::where(['course_id' => $request->id])->delete();

        return redirect('/admin-courses/');
    }
    public function registerCourse(Request $request)
    {

        $all_courses = CommonFunctions::get_all_courses() ;
        $all_student =CommonFunctions::getStudents();

        return view('admin.course.register', compact('all_courses','all_student'));

    }
    public function submitRegisterCourse(Request $request)
    {


        $std_id = $request->std_id;
        $course_id = $request->course_id;
        $get_detail= CommonFunctions::getStudent($std_id);
        $currentSemester = CommonFunctions::getCurrentSemesterByStudent($get_detail->std_admission_year);

        $is_already_exists = StudentCourse::where(['course_id' => $course_id,'std_id'=>$std_id,'semester_no'=>$currentSemester])->first();
        if (!empty($is_already_exists)) {
            return redirect()->back()->with('error', "Course already registered for this student");

        }

        $course = StudentCourse::create([
            'semester_no' => $currentSemester,
            'std_id' => $std_id,
            'course_id' => $course_id,




        ]);
        return redirect()->back()->with('message', "Registered Successfully");

    }


}
