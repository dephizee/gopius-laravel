<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    function index(Request $request)
    {
    	$data['dashboard'] = 'active';
    	// $data['header'] = 'home';
    	// $data['view'] = 'dashboard';
    	return view('admin.login',  $data );
    }

    function processLogin(Request $request)
    {
    	$validated = $request->validate([
            
            'email' => 'required|max:255',
            'password' => 'required',
        ]);
        

        
        if (Auth::guard('admin')->attempt($validated) ) {
            $request->session()->regenerate();
            // session(['s_id' => $student->s_id]);
            return redirect()->route('admin_dashboard');
        }
       
        return back()->withErrors([
            'The provided credentials do not match our records.',
        ]);
    	
    }

    function dashboard(Request $request)
    {
    	$data['dashboard'] = 'active';
    	// $data['header'] = 'home';
    	// $data['view'] = 'dashboard';
    	print("dashboard");
    }
    function logout(Request $request)
    {
        Auth::guard('organization')->logout();
        return redirect()->route('admin_login');
    }
}
