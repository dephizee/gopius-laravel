<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Category;
use App\Models\Instructor;
use App\Models\ClassInstructor;
use App\Models\Course;
use App\Models\Poll;
use App\Models\Assignment;
use App\Models\Quiz;

use Illuminate\Support\Str;



class InstructorController extends Controller
{
    function instructor(Request $request)
    {
        $data['view'] = 'instructors';
        $data['header'] = 'instructor';
        $data['instructor'] = 'active';
        return view('organization.dashboard',  $data );
    }
    
    function allInstructors(Request $request)
    {
        $instructors  = Instructor::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('instr_id')->values();
        return response()->json( $instructors->toArray() )->header('Content-Type', 'application/json');
    }
    function newInstructor(Request $request)
    {
        $data['view'] = 'add_instructor';
        $data['header'] = 'instructor';
        $data['new_instructor'] = 'active';
        $data['categories']  = Category::where("org_no", Auth::guard('organization')->user()->org_id)->cursor();
        return view('organization.dashboard',  $data );
    }
    function processNewInstructor(Request $request)
    {
        // dd($request->input('instr_classes'));die();
        $validated = $request->validate([
            
            'instr_name' => 'required',
            'instr_email' => 'required|unique:instructors,instr_email',
            'instr_phone' => 'required',
            'instr_classes' => 'required',
        ]);
        $validated['open_password'] = Str::random(6);
        $validated['password'] = Hash::make($validated['open_password']);
        $validated['org_no'] = Auth::guard('organization')->user()->org_id;
        $instructor = Instructor::create($validated);
        $classes = $request->input('instr_classes');
        foreach ($classes as $key => $class) {
            $cls = ClassInstructor::create([
                                    'cat_no'=>$class,
                                    'instr_no'=>$instructor->instr_id,
                                    ]);
        }
        return redirect()->route('organization_instuctors');
    }






    
    function instructorDashboard()
    {
        $data['dashboard'] = 'active';
        $data['header'] = 'home';
        $data['view'] = 'dashboard';
        $data['classes']  = ClassInstructor::where("instr_no", Auth::guard('instructor')->user()->instr_id)->get();
        foreach ($data['classes'] as $key => $class) {
           $class->class;
        }
        $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->leftJoin('classes_instructors', 'categories.cat_id', '=', 'classes_instructors.cat_no')
                    ->where('classes_instructors.instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        $data['quizzes']  = Quiz::where('instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        // dd($data['quizzes'][0]);
        return view('instructor.dashboard',  $data );
    }
    function instructorProile(Request $request)
    {
        $data['dashboard'] = 'active';
        $data['header'] = 'home';
        $data['view'] = 'profile';
        $data['classes']  = ClassInstructor::where("instr_no", Auth::guard('instructor')->user()->instr_id)->get();
        foreach ($data['classes'] as $key => $class) {
           $class->class;
        }
        return view('instructor.dashboard',  $data );
    }
    function updateInstructorProile(Request $request)
    {
        $instructor  = Auth::guard('instructor')->user();
        if($instructor->instr_email == $request->input('instr_email')){
            $validated = $request->validate([
            
                'instr_name' => 'required',
               
                'instr_phone' => 'required',
                
            ]);

        }else{
            $validated = $request->validate([
            
                'instr_name' => 'required',
                'instr_email' => 'required|unique:instructors,instr_email',
                'instr_phone' => 'required',
                
            ]);
            $instructor->instr_email = $validated['instr_email'];
        }
        
        
        $instructor->instr_name = $validated['instr_name'];
        
        $instructor->instr_phone = $validated['instr_phone'];
        $instructor->save();
        
        return redirect()->route('instructor_profile');
    }


    function instructorClass(Category $class)
    {
        $data['header'] = 'class';
        $data['view'] = 'class-dashboard';
        $data['class'] = $class;
        $data['class_title'] = $class->cat_title;
        $data['instructors'] = ClassInstructor::where("cat_no", Auth::guard('instructor')->user()->instr_id)->get();
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        $data['polls'] = Poll::where("cat_no", $class->cat_id)->get();
        $data['assignments'] = Assignment::leftJoin('courses', 'assignments.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'assignments.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();
        $data['quizzes'] = Quiz::leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'quizzes.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();

        foreach ($data['instructors'] as $key => $instructor) {
           $instructor->instructor;
        }
        return view('instructor.dashboard',  $data );
    }
    
    function instructorClasses(Request $request)
    {
        $data['view'] = 'classes';
        $data['header'] = 'class';
        $data['class'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    function instructorActivities(Request $request)
    {
        $data['view'] = 'courses';
        $data['header'] = 'course';
        $data['course'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    
    
    function instructorPolls(Request $request)
    {
        $data['view'] = 'polls';
        $data['header'] = 'course';
        $data['poll'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    


    function logout(Request $request)
    {
        Auth::guard('instructor')->logout();
        return redirect()->route('instructor_login');
    }
    function allInstructorClasses(Request $request)
    {
        $classes  = ClassInstructor::where("instr_no", Auth::guard('instructor')->user()->instr_id)->get();
        foreach ($classes as $key => $class) {
           // $class->class;
           $class['m_route'] = route('instructor_class', $class->class->cat_id);
        }
        // $classes  = Category::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('cat_id')->values();
        return response()->json( $classes->toArray() )->header('Content-Type', 'application/json');
    }
}
