<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Category;
use App\Models\Learner;
use App\Models\ClassLearner;
use App\Models\ClassInstructor;


use Illuminate\Support\Str;

class LearnerController extends Controller
{

    function learnerDashboard()
    {
        $data['dashboard'] = 'active';
        $data['header'] = 'home';
        $data['view'] = 'dashboard';
        // $data['classes']  = ClassInstructor::where("instr_no", Auth::guard('learner')->user()->instr_id)->get();
        // foreach ($data['classes'] as $key => $class) {
        //    $class->class;
        // }
        // $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
        //             ->leftJoin('classes_instructors', 'categories.cat_id', '=', 'classes_instructors.cat_no')
        //             ->where('classes_instructors.instr_no', Auth::guard('learner')->user()->instr_id)->get();
        // $data['quizzes']  = Quiz::where('instr_no', Auth::guard('learner')->user()->instr_id)->get();
        // dd($data['quizzes'][0]);
        return view('learner.dashboard',  $data );
    }
    function learnerClasses()
    {
        $data['class'] = 'active';
        $data['header'] = 'class';
        $data['view'] = 'classes';
        return view('learner.dashboard',  $data );
    }
    function learnerActivities()
    {
        $data['activity'] = 'active';
        $data['header'] = 'activity';
        $data['view'] = 'activities';
        // $data['classes']  = ClassInstructor::where("instr_no", Auth::guard('learner')->user()->instr_id)->get();
        // foreach ($data['classes'] as $key => $class) {
        //    $class->class;
        // }
        // $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
        //             ->leftJoin('classes_instructors', 'categories.cat_id', '=', 'classes_instructors.cat_no')
        //             ->where('classes_instructors.instr_no', Auth::guard('learner')->user()->instr_id)->get();
        // $data['quizzes']  = Quiz::where('instr_no', Auth::guard('learner')->user()->instr_id)->get();
        // dd($data['quizzes'][0]);
        return view('learner.dashboard',  $data );
    }




    //Organization...
    function learner(Request $request)
    {
        $data['view'] = 'learners';
        $data['header'] = 'learner';
        $data['learner'] = 'active';
        return view('organization.dashboard',  $data );
    }
    function allLearners(Request $request)
    {
        $learners  = Learner::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('learner_id')->values();
        return response()->json( $learners->toArray() )->header('Content-Type', 'application/json');
    }
    function newLearner(Request $request)
    {
        $data['view'] = 'add_learner';
        $data['header'] = 'learner';
        $data['new_learner'] = 'active';
        $data['categories']  = Category::where("org_no", Auth::guard('organization')->user()->org_id)->cursor();
        return view('organization.dashboard',  $data );
    }

    function processNewLearner(Request $request)
    {
        // dd($request->input('learner_classes'));die();
        $validated = $request->validate([
            
            'learner_name' => 'required',
            'learner_email' => 'required|unique:learners,learner_email',
            'learner_phone' => 'required',
            'learner_classes' => 'required',
        ]);
        $validated['open_password'] = Str::random(6);
        $validated['password'] = Hash::make($validated['open_password']);
        $validated['org_no'] = Auth::guard('organization')->user()->org_id;
        $learner = Learner::create($validated);
        $classes = $request->input('learner_classes');
        foreach ($classes as $key => $class) {
            $cls = ClassLearner::create([
                                    'cat_no'=>$class,
                                    'learner_no'=>$learner->learner_id,
                                    ]);
        }
        return redirect()->route('organization_learners');
    }

    function instructorLearners(Request $request)
    {
        $data['view'] = 'learners';
        $data['header'] = 'learner';
        $data['learner'] = 'active';
        return view('instructor.dashboard',  $data );
    }

    function allInstructorLearners()
    {
        $learner  = ClassLearner::
                    leftJoin('learners', 'classes_learners.learner_no', 'learners.learner_id')
                    // ->leftJoin('categories', 'classes_learners.cat_no', 'categories.cat_id')
                    ->whereIn("classes_learners.cat_no", function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassInstructor)->getTable())
                        ->where('instr_no', Auth::guard('instructor')->user()->instr_id);
                    } )->get();
        return response()->json( $learner->toArray() )->header('Content-Type', 'application/json');
    }
}
