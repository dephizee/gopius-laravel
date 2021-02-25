<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\Category;
use App\Models\Instructor;
use App\Models\ClassInstructor;
use App\Models\ClassLearner;
use App\Models\Course;
use App\Models\Poll;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\Post;
use App\Models\PostInstructor;
use App\Models\PostAttachment;
use App\Models\CommentPost;
use App\Models\PostLike;

use Illuminate\Support\Str;


use App\Mail\SendInstructorLogin;



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
        Mail::to($instructor->instr_email)->send(new SendInstructorLogin($instructor));
        return redirect()->route('organization_instuctors')->with('message', 'InstructorCreated Successfully, Instructor will recieve login details.');
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
        $data['learners']  = ClassLearner::
                    leftJoin('learners', 'classes_learners.learner_no', 'learners.learner_id')
                    // ->leftJoin('categories', 'classes_learners.cat_no', 'categories.cat_id')
                    ->whereIn("classes_learners.cat_no", function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassInstructor)->getTable())
                        ->where('instr_no', Auth::guard('instructor')->user()->instr_id);
                    } )->get();
        $data['posts'] = Post::whereIn("posts.cat_no", function ($query){
                            $query->select('cat_no')
                            ->from(with(new ClassInstructor)->getTable())
                            ->where('instr_no', Auth::guard('instructor')->user()->instr_id);
                        } )
                        ->orderBy('posts.id', 'desc')
                        ->simplePaginate(15);
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
        
        $data['instructors'] = ClassInstructor::where("cat_no", $class->cat_id)->get();
        // dd($data['instructors']);
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        $data['polls'] = Poll::where("cat_no", $class->cat_id)->get();
        $data['posts'] = Post::where("cat_no", $class->cat_id)->orderBy('posts.id', 'desc')->simplePaginate(15);

        // dd($data['posts']);
        $data['assignments'] = Assignment::leftJoin('courses', 'assignments.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'assignments.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();
        $data['quizzes'] = Quiz::leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'quizzes.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();
        $data['learners']  = ClassLearner::
                                leftJoin('learners', 'classes_learners.learner_no', 'learners.learner_id')
                                ->whereIn("classes_learners.cat_no", function ($query){
                                    $query->select('cat_no')
                                    ->from(with(new ClassInstructor)->getTable())
                                    ->where('instr_no', Auth::guard('instructor')->user()->instr_id)
                                    ;
                                } )
                                ->where('classes_learners.cat_no', $class->cat_id)
                                ->get();
        
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

    function instructorUploadClassPost(Request $request, Category $class)
    {
        $validated = $request->validate([
            
            'content' => 'required',
        ]);
        $validated['cat_no'] = $class->cat_id;
        $post = Post::create($validated);
        $post_instructor = PostInstructor::create([
            'instr_no'=>Auth::guard('instructor')->user()->instr_id,
            'post_no'=>$post->id,
        ]);
        if ($request->file('post_attachment') !== null) {
            foreach ($request->file('post_attachment') as $key => $file) {
                $url = $file->store('post_attachment', 'public');
                $post_attachment = PostAttachment::create([
                    'url'=>$url,
                    'post_no'=>$post->id,
                ]);
            }
        }
        $post->class->cat_title;
        $post->attachments;
        $post->likes;
        $post->comments;
        $post->poster = $post->post_instructor->instructor->instr_name??$post->instructor->instr_name??'';
        $post->date = $post->created_at->diffForHumans();
        return response()->json( ['status'=>true, 'post'=>$post] )->header('Content-Type', 'application/json');
    }

    function instructorUploadClassPostComment(Request $request, Category $class)
    {
        $validated = $request->validate([
            'content' => 'required',
            'post_no' => 'required',
        ]);
        $validated['instr_no'] = Auth::guard('instructor')->user()->instr_id;
        $comment_post = CommentPost::create($validated);
        
       
        $comment_post->poster = $comment_post->instructor->instr_name??$post->instructor->instr_name??'';
        $comment_post->date = $comment_post->created_at->diffForHumans();
        return response()->json( ['status'=>true, 'comment_post'=>$comment_post, 'comment_post_count'=>CommentPost::where('post_no', $validated['post_no'] )->count() ] )->header('Content-Type', 'application/json');
    }
    function instructorUploadClassPostLike(Request $request, Category $class)
    {
        $validated = $request->validate([
            'post_no' => 'required',
        ]);
        $validated['instr_no'] = Auth::guard('instructor')->user()->instr_id;
        $like_post = PostLike::where('instr_no', $validated['instr_no'])
                    ->where('post_no', $validated['post_no'] );
        if ($like_post->first() == null) {
            $like_post = PostLike::create($validated);
            return response()->json( ['status'=>true, 'like_post_count'=>PostLike::where('post_no', $validated['post_no'] )->count()] )->header('Content-Type', 'application/json');
        }else{
            $like_post->delete();
        return response()->json( ['status'=>false, 'like_post_count'=>PostLike::where('post_no', $validated['post_no'] )->count() ] )->header('Content-Type', 'application/json');
        }
        
    }
}
