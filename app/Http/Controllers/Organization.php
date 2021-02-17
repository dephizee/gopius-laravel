<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Requirement;
use App\Models\Outcome;

class Organization extends Controller
{
    function index(Request $request)
    {
    	$data['dashboard'] = 'active';
    	$data['header'] = 'home';
    	$data['view'] = 'dashboard';
    	return view('organization.dashboard',  $data );
    }
    
    function timeline(Request $request)
    {
    	$data['header'] = 'home';
    	$data['view'] = 'timeline';
    	$data['timeline'] = 'active';
    	return view('organization.dashboard',  $data );
    }



    function appearance(Request $request)
    {
    	$data['view'] = 'settings';
    	$data['header'] = 'appearance';
    	$data['settings'] = 'active';
    	return view('organization.dashboard',  $data );
    }

    function customize(Request $request)
    {
    	$data['view'] = 'customize';
    	$data['header'] = 'appearance';
    	$data['customize'] = 'active';
    	return view('organization.dashboard',  $data );
    }

    function domainMapping(Request $request)
    {
    	$data['view'] = 'domainMapping';
    	$data['header'] = 'appearance';
    	$data['domainMapping'] = 'active';
    	return view('organization.dashboard',  $data );
    }

    
    

    function courses(Request $request)
    {
        $data['view'] = 'courses';
        $data['header'] = 'course';
        $data['course'] = 'active';
        return view('organization.dashboard',  $data );
    }
    function allCourse(Request $request)
    {
        $courses  = Course::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('course_id')->values();
        return response()->json( $courses->toArray() )->header('Content-Type', 'application/json');
    }
    
    function addUser(Request $request)
    {
    	$data['view'] = 'add_user';
    	$data['header'] = 'users';
    	$data['add_user'] = 'active';
    	return view('organization.dashboard',  $data );
    }

    function logout(Request $request)
    {
        Auth::guard('organization')->logout();
        return redirect()->route('login');
    }
}
