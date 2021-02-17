<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Requirement;
use App\Models\Outcome;

class CourseController extends Controller
{
    function newCourse(Category $class)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'add_course';
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function buildCourse(Category $class, Course $course)
    {
        // $course  = Course::findOrFail($course_id);
        // var_dump($course->course_title);die();
        $data['course'] = $course;
        $data['view'] = 'build_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function processNewCourse(Request $request, Category $class)
    {
        // var_dump($_POST);die();
        $validated = $request->validate([
            
            'course_title' => 'required',
            'course_desc' => 'required',
            'course_status' => 'required',
            'course_cover_image' => 'required|max:2048',
            // 'cat_no' => 'required|exists:categories,cat_id',
        ]);
        $cover_image = $request->file('course_cover_image');
        
        $validated['cat_no'] = $class->cat_id;
        $validated['course_cover_img_url'] = $cover_image->store('cover_images', 'public');
        $course = Course::create($validated);
        unset($validated['course_cover_image']);
        $requirements = $request->input('requirements');
        $outcomes = $request->input('outcomes');
        foreach ($requirements as $key => $requirement) {
            $reqmt = Requirement::create([
                                    'requirement_title'=>$requirement,
                                    'course_no'=>$course->course_id,
                                    ]);
        }
        foreach ($outcomes as $key => $outcome) {
            $outcm = Outcome::create([
                                    'outcome_title'=>$outcome,
                                    'course_no'=>$course->course_id,
                                    ]);
        }
        return redirect()->route('instructor_course_build', [$class->cat_id,$course->course_id,]);
    }

   
    function allCourse(Request $request)
    {
        $courses  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
        			->leftJoin('classes_instructors', 'categories.cat_id', '=', 'classes_instructors.cat_no')
        			->where('classes_instructors.instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        return response()->json( $courses->toArray() )->header('Content-Type', 'application/json');
    }
    
}
