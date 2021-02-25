<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Course;
use App\Models\Requirement;
use App\Models\Outcome;
use App\Models\Setting;
use App\Models\Learner;
use App\Models\Instructor;
use App\Models\Quiz;

class Organization extends Controller
{
    function index(Request $request)
    {
    	$data['dashboard'] = 'active';
    	$data['header'] = 'home';
    	$data['view'] = 'dashboard';
        $data['learners']  = Learner::where("org_no", Auth::guard('organization')->user()->org_id)->orderBy('learner_id', 'desc')->get();
        $data['instructors']  = Instructor::where("org_no", Auth::guard('organization')->user()->org_id)->orderBy('instr_id', 'desc')->get();
    	return view('organization.dashboard',  $data );
    }
    
    function timeline(Request $request)
    {
    	$data['header'] = 'home';
    	$data['view'] = 'timeline';
    	$data['timeline'] = 'active';
        $data['learners']  = Learner::where("org_no", Auth::guard('organization')->user()->org_id)->orderBy('learner_id', 'desc')->get();
        $data['instructors']  = Instructor::where("org_no", Auth::guard('organization')->user()->org_id)->orderBy('instr_id', 'desc')->get();
        $data['classes']  = Category::where("org_no", Auth::guard('organization')->user()->org_id)->orderBy('cat_id', 'desc')->get();
        $data['quizzes']  = Quiz::
                        leftJoin('courses', 'quizzes.course_no', '=', 'courses.course_id')
                        ->leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                        ->where('categories.org_no', Auth::guard('organization')->user()->org_id)->get();
        $data['courses']  = Course::leftJoin('categories', 'courses.cat_no', '=', 'categories.cat_id')
                        ->where('categories.org_no', Auth::guard('organization')->user()->org_id)->get();
        
        // dd($data['quizzes'][0]);
    	return view('organization.dashboard',  $data );
    }



    function appearance(Request $request)
    {
    	$data['view'] = 'settings';
    	$data['header'] = 'appearance';
    	$data['settings'] = 'active';
    	return view('organization.dashboard',  $data );
    }

    function updateAppearance(Request $request)
    {
        // dd($request->input());
        $organization = Auth::guard('organization')->user();
        $organization->about_org = $request->input('about_org');
        $organization->org_phone = $request->input('org_phone');
        $organization->homepage = $request->input('homepage');
        $organization->website = $request->input('website');
        $organization->fb = $request->input('fb');
        $organization->twitter = $request->input('twitter');
        $organization->linkedin = $request->input('linkedin');
        $organization->save();
        
        
        
        return redirect()->route('organization_appearance');
    }

    function customize(Request $request)
    {
        $data['view'] = 'customize';
        $data['header'] = 'appearance';
        $data['customize'] = 'active';
        return view('organization.dashboard',  $data );
    }
    function updateCustomize(Request $request)
    {
        $setting = Setting::where('org_no', Auth::guard('organization')->user()->org_id)->first();
        if ($setting == null) {
            $setting = Setting::create([
                'color'=>$request->input('color'),
                'theme'=>$request->input('theme'),
                'css'=>$request->input('css'),
                'js'=>$request->input('js'),
                'org_no'=>Auth::guard('organization')->user()->org_id,
                
            ]);
        }else{
            $setting->color = $request->input('color');
            $setting->theme = $request->input('theme');
            $setting->css = $request->input('css');
            $setting->js = $request->input('js');
            $setting->save();
        }
        
        
        
        return redirect()->route('organization_customize');
    }

    function domainMapping(Request $request)
    {
    	$data['view'] = 'domainMapping';
    	$data['header'] = 'appearance';
    	$data['domainMapping'] = 'active';
    	return view('organization.dashboard',  $data );
    }
    function updateDomain(Request $request)
    {
        $setting = Setting::where('org_no', Auth::guard('organization')->user()->org_id)->first();
        if ($setting == null) {
            $setting = Setting::create([
                'domain_name'=>$request->input('domain_name'),
                
                'org_no'=>Auth::guard('organization')->user()->org_id,
                
            ]);
        }else{
            $setting->domain_name = $request->input('domain_name');
            $setting->save();
        }
        
        
        
        
        
        
        return redirect()->route('domainMapping');
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
