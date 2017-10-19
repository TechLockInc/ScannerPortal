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

    function index(){
    	return view('delete_route');
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
	            ->withErrors($validator);
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
	    		$message = 'Client code did not match! The subnet ' . $checkRoute->subnet . ' is associated with ' . \App\Appliance::where('id', $checkRoute->gateway)->first()->client_code . ' appliance.';
	    		return back()
	        		->withInput()
	        		->withErrors($message);
	        } else {// If everything looks good

	    	/*	// Delete that route from the server's routing table
	    		$command = 'sudo route delete -net ' . $request->network_address . ' netmask ' . $this->createNetmaskAddr($request->subnet_mask) . ' gw 10.10.10.1 dev wlx60e3270ae8eb';
	    		$process = new Process($command);
				$process->run();

				// If the OS command could not run, return error
				if (!$process->isSuccessful()) {
 				   throw new ProcessFailedException($process);
 				   return back()
	        		->withInput()
	        		->withErrors($message);
				}*/

				// Add the route to database
	        	$checkRoute->delete();
	        	return redirect()->action('ViewApplianceController@index', [$request->client_code]);
	        }
	    }
	}

	// Function to conver from CIDR slash notation to Subnet Mask notation
	function createNetmaskAddr($bitcount) {
    	$netmask = str_split(str_pad(str_pad('', $bitcount, '1'), 32, '0'), 8);
    	foreach ($netmask as &$element) $element = bindec($element);
    	return join('.', $netmask);
    }
}