<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

/**
* 
*/
class DeleteRouteController extends Controller
{
	// Chech for authenticated session
	public function __construct()
    {
        $this->middleware('auth');
    }

    function get(){
    	return view('delete');
    }

	// Process user input
	function output(Request $request){
	    
		// Validate user input
	    $validator = Validator::make($request->all(), [
	        'network_address' => 'required|ip',
	        'subnet_mask' => 'required|Numeric|min:0|max:32',
	        'client_code' => 'required|Alpha|min:3|max:4',
	    ]);
	    // If validation failed, return to the form with error message. This is for preventing bogus requests from hackers
	    if ($validator->fails()) {
	        return back()
	            ->withInput()
	            ->withErrors($validator->getMessages()->all());
	    }

	    $checkAppliance = \App\Appliance::where('client_code', $request->client_code)->first();

	    // If the appliance does not exist, return to the form with error message. This is for preventing bogus requests from hackers
	    if ($checkAppliance == NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('Could not find the provided client code');
	    } else {
	    	$checkRoute = \App\Route::where('subnet', $request->network_address)->first();

	    	// If the provided subnet is not in the database, return error. This is for preventing bogus requests from hackers
	    	if ($checkRoute == NULL){
	    		return back()
	        		->withInput()
	        		->withErrors('Could not find the provide network address!');
	    	} elseif ($checkRoute->gateway != $checkAppliance->id) { // If the gateway ID is not the same as the appliance ID. This for preventing bogus requests from hackers
	    		return back()
	        		->withInput()
	        		->withErrors('Gateway did not match!');
	        } else {
	        	$checkRoute->delete();
	        	return view('view_appliance', ['client_code'=>$request->client_code]);
	        }
	    }
	}
}