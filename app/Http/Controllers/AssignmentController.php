<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Assignment;

class AssignmentController extends Controller
{

    function instructorAssignments(Request $request)
    {
        $data['view'] = 'assignments';
        $data['header'] = 'course';
        $data['assignment'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    function viewAssignment(Category $class, Assignment $assignment)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'view_poll';
        $data['assignment'] = $assignment;
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function newAssignment(Category $class)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'add_assignment';
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        return view('instructor.dashboard',  $data );
    }
    function processNewAssignment(Request $request, Category $class)
    {
        // var_dump($_POST);die();
        $validated = $request->validate([
            
            'ass_title' => 'required',
            'ass_content' => 'required',
            'course_no' => 'required|exists:courses,course_id',
            'end_date' => 'required',
        ]);
        
        $validated['instr_no'] =  Auth::guard('instructor')->user()->instr_id;
        $assignment = Assignment::create($validated);
        
        return redirect()->route('instructor_class', [$class->cat_id,]);
    }

    function allAssignments()
    {
        $assignments  = Assignment::where('instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        // foreach ($assignments as $key => $assignment) {
            // $poll->class;
            // $poll['view_link'] = route('instructor_poll_view', [$poll->class->cat_id, $poll->poll_id]);
        // }
        return response()->json( $assignments->toArray() )->header('Content-Type', 'application/json');
    }
}
