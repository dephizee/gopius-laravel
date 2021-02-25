<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\LearnerQuizOption;
use App\Models\Learner;

use App\Models\Post;
use App\Models\PostInstructor;
use App\Models\QuizPost;

class QuizController extends Controller
{

    function learnerClassQuiz(Request $request, Category $class, Quiz $quiz)
    {
        

        $data['header'] = 'class';
        $data['view'] = 'view-quiz';
        $data['class'] = $class;
        // $data['u_link'] = route('');
        $data['class_title'] = $class->cat_title;
        // $data['instructors'] = ClassInstructor::where("cat_no", Auth::guard('instructor')->user()->instr_id)->get();
        $data['quiz'] = $quiz;
        foreach ($quiz->questions as $key => $question) {
            foreach ($question->options as $key => $option) {
                # code...
            }
        }
        return view('learner.dashboard',  $data );
    }

    function learnerSubmitClassQuiz(Request $request, Category $class, Quiz $quiz)
    {
        
        $questions  = $request->input('questions');
        foreach ($questions as $key => $question) {
            // var_dump(isset($question['quiz_question_id'])?$question['quiz_question_id']:'');
            // var_dump(isset($question['selectedIndex'])?$question['selectedIndex']:'');
            $quiz_option_learner = LearnerQuizOption::firstOrNew([
                'quiz_question_no'=>$question['quiz_question_id'],
                'learner_no'=>Auth::guard('learner')->user()->learner_id,
                'quiz_option_no'=>isset($question['selectedIndex'])?$question['selectedIndex']:null,
                'content'=>isset($question['selected'])?$question['selected']:null,
            ]);
            $quiz_option_learner->save();
        }
        return response()->json( ['status'=>true] )->header('Content-Type', 'application/json');

    }








	function instructorQuizzes(Request $request)
    {
        $data['view'] = 'quizzes';
        $data['header'] = 'course';
        $data['quiz'] = 'active';
        return view('instructor.dashboard',  $data );
    }
    function viewAllQuizSubmissions(Category $class, Quiz $quiz)
    {
        if ($quiz->instructor->instr_id != Auth::guard('instructor')->user()->instr_id) {
            return abort(401);
        }
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'class-quiz-submission';
        $data['quiz'] = $quiz;
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }

    function viewSubmission(Category $class, Quiz $quiz, Learner $learner)
    {
        if ($quiz->instructor->instr_id != Auth::guard('instructor')->user()->instr_id) {
            return abort(401);
        }
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'view_quiz_submission';
        $data['class'] = $class;
        $data['quiz'] = $quiz;
        $data['learner'] = $learner;
        $data['questions'] = LearnerQuizOption::leftJoin('quiz_questions', 
                            'learner_quiz_options.quiz_question_no', 'quiz_questions.quiz_question_id')
                            ->where('learner_quiz_options.learner_no', $learner->learner_id)
                            ->where('quiz_questions.quiz_no', $quiz->quiz_id)
                            ->get();
        
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function submissionStatus(Category $class, Quiz $quiz, LearnerQuizOption $learner_quiz_option, $status)
    {
        
        $learner_quiz_option->status = $status;
        $learner_quiz_option->save(); 
        return redirect()->back();
    }
    function newQuiz(Category $class)
    {
        // $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'add_quiz';
        $data['courses'] = Course::where("cat_no", $class->cat_id)->get();
        return view('instructor.dashboard',  $data );
    }

    function processNewQuiz(Request $request, Category $class)
    {
        // var_dump($_POST);die();
        $validated = $request->validate([
            
            'quiz_title' => 'required',
            'course_no' => 'required|exists:courses,course_id',
            'start_date' => 'required',
            'duration' => 'required',
            'end_date' => 'required',
        ]);
        
        $validated['instr_no'] =  Auth::guard('instructor')->user()->instr_id;
        $quiz = Quiz::create($validated);

        $post = Post::create([
            'content'=>'<b>New Quiz Alert</b>',
            'cat_no'=>$class->cat_id,
            'type'=>'4',
        ]);
        $post_instructor = PostInstructor::create([
            'instr_no'=>Auth::guard('instructor')->user()->instr_id,
            'post_no'=>$post->id,
        ]);
        $poll_post = QuizPost::create([
            'quiz_no'=>$quiz->quiz_id,
            'post_no'=>$post->id,
        ]);
        return redirect()->route('instructor_quiz_build', [$class->cat_id, $quiz->quiz_id]);
    }

    function buildQuiz(Request $request, Category $class, Quiz $quiz)
    {
        // $course  = Course::findOrFail($course_id);
        // var_dump($course->course_title);die();
        $data['quiz'] = $quiz;
        $data['view'] = 'build_quiz';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['categories']  = Category::cursor();
        $data['upload_link']  = $request->url().'/upload';
        return view('instructor.dashboard',  $data );
    }
    function processBuiltQuiz(Request $request, Category $class, Quiz $quiz)
    {
        
        $validated = $request->validate([
            
            'questions' => 'required',
        ]);
        foreach ($validated['questions'] as $question) {
        	$multiple_select = isset($question['multi_options'])? $question['multi_options']: '0';
        	$quiz_question = QuizQuestion::create([
        		'quiz_question_title'=>$question['question'],
        		'type'=>$question['type'],
        		'multiple_select'=>$multiple_select,
        		'quiz_no'=>$quiz->quiz_id,
        	]);
        	
        	foreach ($question['options'] as $key => $option) {
        		$quiz_option = QuizOption::create([
	        		'quiz_option_title'=>$option['value'],
	        		'is_correct'=>$option['checked'],
	        		'quiz_question_no'=>$quiz_question->quiz_question_id,
	        	]);
        	}
        }
        return response()->json( ['status'=>true] )->header('Content-Type', 'application/json');
    }

    function allQuizzes()
    {
        $quizzes  = Quiz::where('instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        foreach ($quizzes as $key => $quiz) {
            $quiz['view_link'] = route('instructor_quiz_submissions', [$quiz->course->category->cat_id, $quiz->quiz_id]) ;

        }
        return response()->json( $quizzes->toArray() )->header('Content-Type', 'application/json');
    }

    function getAllSubmittedQuizzes(Category $class, Quiz $quiz)
    {
        DB::statement("set sql_mode = ''");
        $quizzes  = LearnerQuizOption::
                        leftJoin('quiz_questions', 'learner_quiz_options.quiz_question_no', '=', 'quiz_questions.quiz_question_id')
                        ->leftJoin('quizzes', 'quiz_questions.quiz_no', '=', 'quizzes.quiz_id')
                        ->leftJoin('learners', 'learner_quiz_options.learner_no', '=', 'learners.learner_id')
                        ->where('quizzes.quiz_id', $quiz->quiz_id)->groupBy('learners.learner_id')->get(['*', 'learner_quiz_options.created_at AS submission_date']);
        foreach ($quizzes as $key => $quiz) {
            // $assignment->class;
            $quiz['view_link'] = route('instructor_view_quiz_submission', [$class->cat_id, $quiz->quiz_id, $quiz->learner_id]);
            $quiz['questions'] = LearnerQuizOption::leftJoin('quiz_questions', 
                            'learner_quiz_options.quiz_question_no', 'quiz_questions.quiz_question_id')
                            ->where('learner_quiz_options.learner_no', $quiz->learner_no)
                            ->where('quiz_questions.quiz_no', $quiz->quiz_id)
                            ->get();
            $quiz['correct_option'] = 0;
            $quiz['unattented_option'] = 0;
            foreach ($quiz['questions'] as $question) {
                if ($question->type == 'short_answer') {
                    if ($question->status==1) {
                        $quiz['correct_option'] += 1;
                    }
                    if ($question->status==0) {
                        $quiz['unattented_option'] += 1;
                    }
                }
                foreach ($question->options as $option) {
                    if (isset($question->quiz_option_no) && $question->quiz_option_no == $option->quiz_option_id && $option->is_correct == 1) {
                        $quiz['correct_option'] += 1;
                    }
                }
            }
        }
        return response()->json( $quizzes->toArray() )->header('Content-Type', 'application/json');
    }




}
