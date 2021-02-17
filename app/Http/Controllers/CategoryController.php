<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryController extends Controller
{
    function classes(Request $request)
    {
        $data['view'] = 'classes';
        $data['header'] = 'class';
        $data['class'] = 'active';
        return view('organization.dashboard',  $data );
    }

    function allClass(Request $request)
    {
        $classes  = Category::get()->where("org_no", Auth::guard('organization')->user()->org_id)->sortByDesc('cat_id')->values();
        return response()->json( $classes->toArray() )->header('Content-Type', 'application/json');
    }

    function newClass(Request $request)
    {
        $data['view'] = 'add_class';
        $data['header'] = 'class';
        $data['new_class'] = 'active';
        // $data['categories']  = Category::cursor();
        return view('organization.dashboard',  $data );
    }

    function processNewClass(Request $request)
    {
       
        $validated = $request->validate([
            
            'cat_title' => 'required',
            'cat_desc' => 'required',
            'cat_code' => 'required|unique:categories,cat_code',
            'cat_status' => 'required',
            'cat_max_student' => 'required',
        ]);
        
        $validated['org_no'] = Auth::guard('organization')->user()->org_id;
         // dd($validated);die();
        $course = Category::create($validated);
        
        
        return redirect()->route('organization_classes');
    }
}
