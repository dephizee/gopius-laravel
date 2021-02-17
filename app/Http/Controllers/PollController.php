<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Poll;
use App\Models\PollOption;

class PollController extends Controller
{
    function viewPoll(Category $class, Poll $poll)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'view_poll';
        $data['poll'] = $poll;
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function newPoll(Category $class)
    {
        $data['dashboard'] = 'add_course';
        $data['header'] = 'class';
        $data['class_title'] = $class->cat_title;
        $data['view'] = 'add_poll';
        // $data['categories']  = Category::cursor();
        return view('instructor.dashboard',  $data );
    }
    function processNewPoll(Request $request, Category $class)
    {
        // var_dump($_POST);die();
        $validated = $request->validate([
            
            'poll_title' => 'required',
            'end_date' => 'required',
            'optionsArr' => 'required',
        ]);
        unset($validated['optionsArr']);
        $validated['cat_no'] = $class->cat_id;
        $validated['instr_no'] =  Auth::guard('instructor')->user()->instr_id;
        $poll = Poll::create($validated);
        
        $options_arr = $request->input('optionsArr');

        foreach ($options_arr as $key => $option) {
            $popt = PollOption::create([
                                    'poll_option_title'=>$option,
                                    'poll_no'=>$poll->poll_id,
                                    ]);
        }
        return redirect()->route('instructor_class', [$class->cat_id,]);
    }

    function allPolls()
    {
        $polls  = Poll::where('instr_no', Auth::guard('instructor')->user()->instr_id)->get();
        foreach ($polls as $key => $poll) {
            // $poll->class;
            $poll['view_link'] = route('instructor_poll_view', [$poll->class->cat_id, $poll->poll_id]);
        }
        return response()->json( $polls->toArray() )->header('Content-Type', 'application/json');
    }
}
