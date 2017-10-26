<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

/**
* 
*/
class AddApplianceController extends Controller
{
	// Check for authenticated session
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	// Return to add_appliance form in Views
	function input(){
		return view('add_appliance');
	}

	// Process input data
	function output(Request $request){

		// Validate user input
	    $validator = Validator::make($request->all(), [
	        'client_code' => 'required|min:3|max:4|Alpha',
	        'client_name' => 'required|max:255',
	        'tunnel' => 'required|ip',
	        'external' => 'required|ip',
	        'hostname' => 'required|Alpha_Num',
	    ]);

		// If validation failed, return to the form with error message
	    if ($validator->fails()) {
	    	echo $request->client_code;
	        return back()
	        		->withInput()
	        		->withErrors($validator);
	    }

	    // Check for existing client code in the database
	    $appliance = \App\Appliance::where('client_code', $request->client_code)->first();
	    if ($appliance != NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('Client already exists in the database!');
	    }

	    // Check for existing client name in the database
	    $appliance = \App\Appliance::where('client_name', $request->client_name)->first();
	    if ($appliance != NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('Client already exists in the database!');
	    }

	    // Chech for existing tunnel IP in the database
	    $appliance = \App\Appliance::where('tunnel', $request->tunnel)->first();
	    if ($appliance != NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('The provided tunnel IP already exists in the database');
	    }

	    // Check for existing external IP in the database
	    $appliance = \App\Appliance::where('external', $request->client_code)->first();
	    if ($appliance != NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('The provided external IP already exists in the database!');
	    }

	    //Check for existing hostname
	    $vm = \App\Vm::where('hostname', strtoupper($request->hostname))->first();
	    if ($vm == NULL) {
	    	return back()
	    			->withInput()
	        		->withErrors('Could not find the provided hostname in the database. Please check if the hostname is correct!');
	    }

	    //Check if the hostname is currently associated with any client
	    $appliance = \App\Appliance::where('hostname', $vm->id)->first();
	    if ($appliance != NULL) {
	    	$message = 'The hostname ' . strtoupper($request->hostname) . ' is currently associated with ' . $appliance->client_code . '!';
	    	return back()
	    			->withInput()
	        		->withErrors($message);
	    }

	    // If passing all checks, add the appliance to the database
	    $appliance = new \App\Appliance;
	    $appliance->client_code = strtoupper($request->client_code);
	    $appliance->client_name = $request->client_name;
	    $appliance->tunnel = $request->tunnel;
	    $appliance->external = $request->external;
	    $appliance->hostname = \App\Vm::where('hostname', strtoupper($request->hostname))->first()->id;
	    $appliance->save();
	    $message = 'Appliance ' . strtoupper($request->client_code) . ' was added successfully!';
	    $request->session()->flash('success', $message);
	    return view('home');
	}
}