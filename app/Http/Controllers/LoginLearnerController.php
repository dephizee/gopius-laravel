<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginLearnerController extends Controller
{
	public function index(Request $request)
    {
    	return view('learner.login');
    }
    function processLogin(Request $request)
    {
    	$validated = $request->validate([
            
            'email' => 'required|max:255.',
            'password' => 'required',
        ]);
        
    	$validated['learner_email'] = $validated['email'];
        unset($validated['email']);
        
        if (Auth::guard('learner')->attempt($validated) ) {
            $request->session()->regenerate();
            // session(['s_id' => $student->s_id]);
            return redirect('/learner');
        }
       
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    	
    }
}
