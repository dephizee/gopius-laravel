<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Country;
use App\Models\State;
use App\Models\VerifyOrganizationTable;

use App\Mail\RegistrationSuccessful;


class LoginOrganization extends Controller
{
    public function index(Request $request)
    {
    	return view('organization.login');
    }
    function processLogin(Request $request)
    {
    	$validated = $request->validate([
            
            'email' => 'required|max:255',
            'password' => 'required',
        ]);
        
        
        if (Auth::guard('organization')->attempt($validated) ) {
            $request->session()->regenerate();
            // session(['s_id' => $student->s_id]);
            return redirect('/organization');
        }
       
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    	
    }
    

    function registerView(Request $request)
    {
    	$data['org_types']   = OrganizationType::cursor();
    	$data['countries']  = Country::cursor();
    	
    	if ($request->session()->has('status')) {
		    $data['status'] = 'Registration was successful!';
		}
    	// dd($countries);
    	return view('organization.register', $data);
    }

    function stateJson(Request $request, $country_id)
    {
    	$org_types  = OrganizationType::cursor();
    	$states  = State::where("country_id", $country_id)->orderBy('name')->get();

    	return response()->json( $states->toArray() )->header('Content-Type', 'application/json');
    }

    function registerProcess(Request $request)
    {
    	// dd($request->all());
    	$validated = $request->validate([
	        'firstname' => 'required|max:255',
	        'lastname' => 'required|max:255',
	        'email' => 'required|unique:organizations|max:255',
	        'phone' => 'required|max:255',
            'org_name' => 'required|max:255',
            'org_size' => 'required|max:255',
            'org_priority' => 'required|max:255',
	        'org_why' => 'required|max:255',
	        'org_type_no' => 'required|exists:organization_types,org_type_id',
	        'org_address' => 'required|max:255',
	        'state_no' => 'required|max:255',
	        'about_org' => 'required|max:255',
	        'password' => 'required',
	    ]);
        $validated['password'] = Hash::make($validated['password']);
	    $organization = Organization::create($validated);
	    
        // Auth::guard('organization')->login($organization);
        $request->session()->flash('message', 'Registration was successful, Check Email to finish Registration!');
        $verifyOrganization = VerifyOrganizationTable::create([
            'org_no' => $organization->org_id,
            'token' => sha1(time())
        ]);
        Mail::to($organization)->send(new RegistrationSuccessful($organization));
	    return redirect()->route('login');

    	// return view('organization.register', $data);
    }

    function registerVerifyToken($token)
    {
        $verifyOrg = VerifyOrganizationTable::where('token', $token)->first();
        if(isset($verifyOrg) ){
            $org = $verifyOrg->organization;
            if(!$org->approved) {
              $org->approved = 1;
              $org->save();
              $status = "Your e-mail is verified. You can now login.";
            } else {
              $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return abort(404);
        }
        $verifyOrg->token = sha1(time());
        $verifyOrg->save();
        return redirect()->route('login')->with('message', $status);
    }
}
