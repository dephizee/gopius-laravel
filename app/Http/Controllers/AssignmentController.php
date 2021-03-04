<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentLearner;
use App\Models\Attachment;

use App\Models\Post;
use App\Models\PostInstructor;
use App\Models\AssignmentPost;

class AssignmentController extends Controller
{


    function learnerClassAssignment( $account, Category $class, Assignment $assignment)
    {
        

        $data['header'] = 'class';
        $data['view'] = 'view-assignment';
        $data['class'] = $class;
        $data['class_title'] = $class->cat_title;
        // $data['instructors'] = ClassInstructor::where("cat_no", Auth::guard('instructor')->user()->instr_id)->get();
        $data['assignment'] = $assignment;
        return view('learner.dashboard',  $data );
    }
    function learnerSubmitClassAssignment(Request $request, $account, Category $class, Assignment $assignment)
    {
        
        $validated = $request->validate([
            'ass_answer' => 'required',
        ]);
      
        
        $validated['learner_no'] =  Auth::guard('learner')->user()->learner_id;
        $validated['ass_no'] =  $assignment->ass_id;
        
        $attachments =  $request->file('attachments');
        // dd( isset($attachments) );
        if (isset($attachments)) {
            foreach ($attachments as $key => $attachment) {
                $rr = new Request([
                    'file'=> $attachment
                ]);
                $vd = $rr->validate([
                    'file' => 'required|max:1000000|mimes:jpeg,pdf,pptx,ppt,docx,doc,png',
                ]);
            }
        }
        $assignment_learner = AssignmentLearner::firstOrNew($validated);
        $assignment_learner->save();
            if (isset($attachments)) {
            foreach ($attachments as $key => $attachment) {
                $url = $attachment->store('assignment_attachments', 'public');
                $att = Attachment::create([
                    'url' => $url,
                    'type' => $attachment->getClientOriginalExtension(),
                    'ass_learner_no' => $assignment_learner->id,
                ]);
            }
        }

        // dd($attachments);
        
        return redirect()->route('learner_class', [$class->cat_id,]);
    }
    
















    function instructorAssignments()
    {
        $data['view'] = 'assignments';
        $data['header'] = 'course';
        $data['assignment'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    function viewAllAssignmentSubmissions($account, Category $class, Assignment $assignment)
    {
        if ($assignment->instructor->instr_id != Auth::guard('instructor')->user()->instr_id) {
            return abort(401);
        }
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'class-assignment-submission';
        $data['assignment'] = $assignment;
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function viewSubmission($account, Category $class, Assignment $assignment, AssignmentLearner $assignment_learner)
    {
        if ($assignment->instructor->instr_id != Auth::guard('instructor')->user()->instr_id) {
            return abort(401);
        }
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'view_assigment_submitted';
        $data['class'] = $class;
        $data['assignment'] = $assignment;
        $data['assignment_learner'] = $assignment_learner;
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function submissionStatus($account, Category $class, Assignment $assignment, AssignmentLearner $assignment_learner, $status)
    {
        
        $assignment_learner->status = $status;
        $assignment_learner->save(); 
        return redirect()->back();
    }

    function newAssignment($account, Category $class)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'add_assignment';
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        return view('instructor.dashboard',  $data );
    }
    function processNewAssignment(Request $request, $account, Category $class)
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
        

        $post = Post::create([
            'content'=>'<b>New Assignment Alert</b>',
            'cat_no'=>$class->cat_id,
            'type'=>'3',
        ]);
        $post_instructor = PostInstructor::create([
            'instr_no'=>Auth::guard('instructor')->user()->instr_id,
            'post_no'=>$post->id,
        ]);
        $course_post = AssignmentPost::create([
            'ass_no'=>$assignment->ass_id,
            'post_no'=>$post->id,
        ]);
        return redirect()->route('instructor_class', [$class->cat_id,]);
    }

    function allAssignments()
    {
        $assignments  = Assignment::where('instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        // foreach ($assignments as $key => $assignment) {
            // $poll->class;
            // $poll['view_link'] = route('instructor_poll_view', [$poll->class->cat_id, $poll->poll_id]);
        // }
        foreach ($assignments as $key => $assignment) {
            // $assignment->class;
            $assignment['view_link'] = route('instructor_assignment_submissions', [$assignment->course->category->cat_id, $assignment->ass_id]) ;
        }
        return response()->json( $assignments->toArray() )->header('Content-Type', 'application/json');
    }
    function getAllSubmittedAssignments($account, Category $class, Assignment $assignment)
    {
        $assignments  = AssignmentLearner::
                        leftJoin('assignments', 'assignment_learners.ass_no', '=', 'assignments.ass_id')
                        ->leftJoin('learners', 'assignment_learners.learner_no', '=', 'learners.learner_id')
                        ->where('ass_no', $assignment->ass_id)->get(['*', 'assignment_learners.created_at AS submission_date' , 'assignment_learners.id AS assignment_learner_id' ]);
        foreach ($assignments as $key => $assignment) {
            // $assignment->class;
            $assignment['view_link'] = route('instructor_view_assignment_submission', [$class->cat_id, $assignment->ass_id, $assignment->assignment_learner_id]);
        }
        return response()->json( $assignments->toArray() )->header('Content-Type', 'application/json');
    }

}
