<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Requirement;
use App\Models\Outcome;
use App\Models\Block;
use App\Models\BlockLearner;

use App\Models\Post;
use App\Models\PostInstructor;
use App\Models\CoursePost;

class CourseController extends Controller
{


    function learnerClassCourse(Category $class, Course $course)
    {
        $data['header'] = 'class';
        $data['view'] = 'intro-to-course';
        $data['class'] = $class;
        $data['class_title'] = $class->cat_title;
        // $data['instructors'] = ClassInstructor::where("cat_no", Auth::guard('instructor')->user()->instr_id)->get();
        $data['course'] = $course;
        return view('learner.dashboard',  $data );
    }
    function learnerClassCourseLearn(Category $class, Course $course)
    {
        $data['header'] = 'class';
        $data['view'] = 'learn-course';
        $data['class'] = $class;
        $data['class_title'] = $class->cat_title;
        // $data['instructors'] = ClassInstructor::where("cat_no", Auth::guard('instructor')->user()->instr_id)->get();
        $data['course'] = $course;
        return view('learner.dashboard',  $data );
    }
    function learnerClassCourseLearnTicked(Category $class, Course $course, Block $block)
    {
        $bl = BlockLearner::firstOrNew([
            'block_no'=>$block->block_id,
            'learner_no'=> Auth::guard('learner')->user()->learner_id,
        ]);
        $bl->viewed = !$bl->viewed;
        $bl->save();

        return response()->json( $bl )->header('Content-Type', 'application/json');
    }












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
        $validated['instr_no'] = Auth::guard('instructor')->user()->instr_id;
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
        $post = Post::create([
            'content'=>'<b>New Course Alert</b>',
            'cat_no'=>$class->cat_id,
            'type'=>'1',
        ]);
        $post_instructor = PostInstructor::create([
            'instr_no'=>Auth::guard('instructor')->user()->instr_id,
            'post_no'=>$post->id,
        ]);
        $course_post = CoursePost::create([
            'course_no'=>$course->course_id,
            'post_no'=>$post->id,
        ]);
        return redirect()->route('instructor_course_build', [$class->cat_id,$course->course_id,]);
    }

   
    function allCourse(Request $request)
    {
        $courses  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
        			->leftJoin('classes_instructors', 'categories.cat_id', '=', 'classes_instructors.cat_no')
        			->where('classes_instructors.instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        return response()->json( $courses->toArray() )->header('Content-Type', 'application/json');
    }
    function updateCourse(Request $request, Course $course)
    {
        // dd($request->input());
        $validated = $request->validate([
            
            'course_title' => 'required',
            'course_desc' => 'required',
            'course_status' => 'required',
           
        ]);
        $course->course_title = $validated['course_title'];
        $course->course_desc = $validated['course_desc'];
        $course->course_status = $validated['course_status'];
        $course->save();
        return response()->json( $course->toArray() )->header('Content-Type', 'application/json');
    }
    function deleteCourse(Request $request, Course $course)
    {
        
        $course->delete();
        return response()->json( $course->toArray() )->header('Content-Type', 'application/json');
    }
}
