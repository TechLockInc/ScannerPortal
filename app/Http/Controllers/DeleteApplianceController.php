<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

/**
* 
*/
class DeleteApplianceController extends Controller
{
	// Chech for authenticated session
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	// Return to delete_appliance form in Views
	function input(){
		return view('delete_appliance');
	}

	// Process user input
	function output(Request $request){
	    
		// Validate user input
	    $validator = Validator::make($request->all(), [
	        'client_code' => 'required|min:3|max:4|Alpha',
	    ]);

	    // If validation failed, return to the form with error message
	    if ($validator->fails()) {
	        return back()
	            ->withInput()
	            ->withErrors($validator);
	    }
	    
	    // Check for existing appliance in the database with provided client code
	    $appliance = \App\Appliance::where('client_code', strtoupper($request->client_code))->first();
	    if ($appliance != NULL){ // If there exist a record for provide client code

	    	// Delete all routes associated with that appliance to prevent foreign key error
	    	$route = \App\Route::where('gateway', $appliance->id)->first();
	    	while ($route != NULL){
	    		$route->delete();
	    		$route = \App\Route::where('gateway', $appliance->id)->first();
	    	}

	    	// Delete the appliance
	    	$appliance->delete();
	    	$message = 'Appliance ' . strtoupper($request->client_code) . ' was deleted successfully!';
		    $request->session()->flash('success', $message);
		    return view('home');
	    } else { // If the provided client code does not exist in the database, return error
	    	return back()
	        		->withInput()
	        		->withErrors('Could not find the provided client code');
	    }
	}
}