<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

/**
* 
*/
class ViewApplianceController extends Controller
{
	// Chech for authenticated session
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	// Return to delete_appliance form in Views
	function index($client_code){
		return view('view_appliance', ['client_code'=>$client_code]);
	}

	function addRoute(Request $request){

		// Validate user input
	    $validator = Validator::make($request->all(), [
	        'network_address' => 'required|ip',
	        'subnet_mask' => 'required|Numeric|min:0|max:32',
	        'client_code' => 'required|Alpha|min:3|max:4',
	    ]);

		// If validation failed, return to the form with error message
	    if ($validator->fails()) {
	        return back()
	        		->withInput()
	        		->withErrors($validator);
	    }

	    $checkAppliance = \App\Appliance::where('client_code', $request->client_code)->first();

	    // If the appliance does not exist, return to the form with error message
	    if ($checkAppliance == NULL){
	    	return back()
	        		->withInput()
	        		->withErrors('Could not find the provided client code');
	    } else { // if the appliance was fourd, check for exsisted subnet
	    	$checkRoute = \App\Route::where('subnet', $request->network_address)->first();

	    	// If there already existsted a route to the same subnet in the database regardless of appliance, return error message for routing conflict
	    	if (!($checkRoute == Null)){
	    		$checkAppliance = \App\Appliance::where('id', $checkRoute->gateway)->first();
	    		$message = 'There exists a route to subnet ' . $checkRoute->subnet . ' associated with ' . $checkAppliance->client_code . ' appliance.';
	    		return back()
	        		->withInput()
	        		->withErrors($message);
	    	} else { // If everything looks good

	    	/*	// Add that route to the server's routing table
	    		$command = 'sudo route add -net ' . $request->network_address . ' netmask ' . $this->createNetmaskAddr($request->subnet_mask) . ' gw 10.10.10.1 dev wlx60e3270ae8eb';
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
	    		$route = new \App\Route;
	    		$route->subnet = $request->network_address;
	    		$route->mask = $this->createNetmaskAddr($request->subnet_mask);
	    		$route->gateway = $checkAppliance->id;
	    		$route->save();
	    		$message = 'The subnet ' . $request->network_address . ' was added successfully!';
		    	$request->session()->flash('success', $message);
	    		return back();
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