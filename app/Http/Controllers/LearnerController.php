<?php

namespace App\Http\Controllers;

use App\Mail\SendLearnerLogin;
use App\Models\Assignment;
use App\Models\Category;
use App\Models\ClassInstructor;
use App\Models\ClassLearner;
use App\Models\CommentPost;
use App\Models\Course;
use App\Models\Learner;
use App\Models\Poll;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\PostLearner;
use App\Models\PostLike;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LearnerController extends Controller
{

    function learnerDashboard()
    {
        $data['dashboard'] = 'active';
        $data['header'] = 'home';
        $data['view'] = 'dashboard';
        $data['classes']  = ClassLearner::where("learner_no", Auth::guard('learner')->user()->learner_id)->get();
        $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->leftJoin('classes_learners', 'categories.cat_id', '=', 'classes_learners.cat_no')
                    ->where('classes_learners.learner_no', Auth::guard('learner')->user()->learner_id)->get();
        $data['assignments']  = Assignment::leftJoin('courses', 'assignments.course_no', '=', 'courses.course_id')
                    ->leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->whereIn('categories.cat_id', function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    })->get();
        $data['quizzes']  = Quiz::leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                    ->leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->whereIn('categories.cat_id', function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    })->get();

        $data['posts'] = Post::whereIn("posts.cat_no", function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    } )
                    ->orderBy('posts.id', 'desc')
                    ->simplePaginate(15);
        foreach ($data['courses'] as $key => $course) {
            $course['block_count'] = 0;
            $course['block_count_viewed'] = 0;
            foreach ($course->chapters as  $chapter) {
                $course['block_count'] += count($chapter->blocks);
                foreach ($chapter->blocks as $block) {
                    $course['block_count_viewed']+= $block->blockLearner[0]->viewed??0;
                }
            }
            
        }
        
        return view('learner.dashboard',  $data );
    }
    function learnerProfile()
    {
        $data['dashboard'] = 'active';
        $data['header'] = 'home';
        $data['view'] = 'profile';
        return view('learner.dashboard',  $data );
    }
    function updateLearnerProile(Request $request)
    {
        $learner  = Auth::guard('learner')->user();
        if($learner->learner_email == $request->input('learner_email')){
            $validated = $request->validate([
            
                'learner_name' => 'required',
               
                'learner_phone' => 'required',
                
            ]);

        }else{
            $validated = $request->validate([
            
                'learner_name' => 'required',
                'learner_email' => 'required|unique:learners,learner_email',
                'learner_phone' => 'required',
                
            ]);
            $learner->learner_email = $validated['learner_email'];
        }
        

        
        $learner->learner_name = $validated['learner_name'];
        
        $learner->learner_phone = $validated['learner_phone'];

        if ($request->file('profile_avatar') !== null && $request->file('profile_avatar')->getSize() < 2200000) {
            
            Storage::delete('public/'. $learner->learner_avatar_url);
            $learner->learner_avatar_url = $request->file('profile_avatar')->store('learner_images', 'public');
        }
        $learner->save();
        
        return redirect()->route('learner_profile');
    }
    function learnerClasses(Category $class)
    {
        $data['class'] = 'active';
        $data['header'] = 'class';
        $data['view'] = 'classes';
        $data['instructors'] = ClassInstructor::where("cat_no", $class->cat_id)->get();
        return view('learner.dashboard',  $data );
    }
    function learnerCourses()
    {
        $data['course'] = 'active';
        $data['header'] = 'course';
        $data['view'] = 'courses';
        $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->leftJoin('classes_learners', 'categories.cat_id', '=', 'classes_learners.cat_no')
                    ->where('classes_learners.learner_no', Auth::guard('learner')->user()->learner_id)->get();
        foreach ($data['courses'] as $key => $course) {
            $course['block_count'] = 0;
            $course['block_count_viewed'] = 0;
            foreach ($course->chapters as  $chapter) {
                $course['block_count'] += count($chapter->blocks);
                foreach ($chapter->blocks as $block) {
                    $course['block_count_viewed']+= $block->blockLearner[0]->viewed??0;
                }
            }
            
        }
        return view('learner.dashboard',  $data );
    }
    function learnerAssignments()
    {
        $data['assignment'] = 'active';
        $data['header'] = 'course';
        $data['view'] = 'assignments';
        $data['assignments']  = Assignment::leftJoin('courses', 'assignments.course_no', '=', 'courses.course_id')
                    ->leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->whereIn('categories.cat_id', function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    })->get();
        return view('learner.dashboard',  $data );
    }
    function learnerQuizzes()
    {
        $data['quiz'] = 'active';
        $data['header'] = 'course';
        $data['view'] = 'quizzes';
        $data['quizzes']  = Quiz::leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                    ->leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                    ->whereIn('categories.cat_id', function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    })->get();
        return view('learner.dashboard',  $data );
    }
    

    function allLearnerClasses(Request $request)
    {
        $classes  = ClassLearner::where("learner_no", Auth::guard('learner')->user()->learner_id)->get();
        foreach ($classes as $key => $class) {
           $class->class;
           $class['m_route'] = route('learner_class', $class->class->cat_id);
        }
        // $classes  = Category::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('cat_id')->values();
        return response()->json( $classes->toArray() )->header('Content-Type', 'application/json');
    }

    function learnerClass(Category $class)
    {
        $data['header'] = 'class';
        $data['view'] = 'class-dashboard';
        $data['class'] = $class;
        $data['class_title'] = $class->cat_title;
        $data['instructors'] = ClassInstructor::where("cat_no", $class->cat_id)->get();
        $data['posts'] = Post::where("cat_no", $class->cat_id)->orderBy('posts.id', 'desc')->simplePaginate(15);
        
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        $data['polls'] = Poll::where("cat_no", $class->cat_id)->get();
        $data['assignments'] = Assignment::leftJoin('courses', 'assignments.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'assignments.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();
        $data['quizzes'] = Quiz::leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                                ->leftJoin('instructors', 'quizzes.instr_no', '=', 'instructors.instr_id')

                                ->where("courses.cat_no", $class->cat_id)->get();

        // foreach ($data['instructors'] as $key => $instructor) {
        //    $instructor->instructor;
        // }
        return view('learner.dashboard',  $data );
    }


    function learnerPolls()
    {
        $data['poll'] = 'active';
        $data['header'] = 'course';
        $data['view'] = 'polls';
        $data['polls']  = Poll::leftJoin('categories', 'polls.cat_no', '=', 'categories.cat_id')
                    ->whereIn('categories.cat_id', function ($query){
                        $query->select('cat_no')
                        ->from(with(new ClassLearner)->getTable())
                        ->where('learner_no', Auth::guard('learner')->user()->learner_id);
                    })->get();
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
    function sendLearnerMail(Learner $learner)
    {
        Mail::to($learner->learner_email)->send(new SendLearnerLogin($learner));
        return response()->json( [
            'status' => true,
            'message' => 'Learner Mail Sent Successfully, Learner will recieve login details.',
        ] )->header('Content-Type', 'application/json');
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
        Mail::to($learner->learner_email)->send(new SendLearnerLogin($learner));
        return redirect()->route('organization_learners')->with('message', 'Learner Created Successfully, Learner will recieve login details.');
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

    function logout(Request $request)
    {
        Auth::guard('learner')->logout();
        return redirect()->route('learner_login');
    }

     function learnerUploadClassPost(Request $request, Category $class)
    {
        $validated = $request->validate([
            
            'content' => 'required',
        ]);
        $validated['cat_no'] = $class->cat_id;
        $post = Post::create($validated);
        $post_instructor = PostLearner::create([
            'learner_no'=>Auth::guard('learner')->user()->learner_id,
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

    function learnerUploadClassPostComment(Request $request, Category $class)
    {
        $validated = $request->validate([
            'content' => 'required',
            'post_no' => 'required',
        ]);
        $validated['learner_no'] = Auth::guard('learner')->user()->learner_id;
        $comment_post = CommentPost::create($validated);
        
       
        $comment_post->poster = $comment_post->instructor->instr_name??$post->instructor->instr_name??'';
        $comment_post->date = $comment_post->created_at->diffForHumans();
        return response()->json( ['status'=>true, 'comment_post'=>$comment_post, 'comment_post_count'=>CommentPost::where('post_no', $validated['post_no'] )->count() ] )->header('Content-Type', 'application/json');
    }
    function learnerUploadClassPostLike(Request $request, Category $class)
    {
        $validated = $request->validate([
            'post_no' => 'required',
        ]);
        $validated['learner_no'] = Auth::guard('learner')->user()->learner_id;
        $like_post = PostLike::where('learner_no', $validated['learner_no'])
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
