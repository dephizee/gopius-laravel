<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;

class QuizController extends Controller
{


	function instructorQuizzes(Request $request)
    {
        $data['view'] = 'quizzes';
        $data['header'] = 'course';
        $data['quiz'] = 'active';
        return view('instructor.dashboard',  $data );
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
        return response()->json( $quizzes->toArray() )->header('Content-Type', 'application/json');
    }




}
