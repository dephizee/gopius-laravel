<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginInstructor extends Controller
{

	
    function index(Request $request)
    {
    	return view('instructor.login');
    }
    function processLogin(Request $request)
    {
    	$validated = $request->validate([
            
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        $validated['instr_email'] = $validated['email'];
        unset($validated['email']);
        

        
        if (Auth::guard('instructor')->attempt($validated) ) {
            $request->session()->regenerate();
            // session(['s_id' => $student->s_id]);
            return redirect()->route('instructor_dashboard');
        }
       
        return back()->withErrors([
             'instructor credentials do not match our records.',
        ]);
    	
    }
}
