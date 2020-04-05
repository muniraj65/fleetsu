<?php
  
namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Config;
 
class QuoteController extends Controller
{
	

    public function index($company = null)
    {
    	$REST_URL				= Config::get('app.rest_url');
    	$client 				= new \GuzzleHttp\Client();
    	try {
    		$response = $client->request('GET', $REST_URL . '/quote/' . $company);
	        return $response->getBody();
    	}catch (\Exception $e){ 
    		return Helper::response('Error', $e->getMessage().$e->getLine(),0);
    	}
		// echo $response->getStatusCode();
		// echo $response->getReasonPhrase();
		

		//asynchronous 
    	/* $request = new \GuzzleHttp\Psr7\Request('GET', $REST_URL . 'company/profile/AAPL');
		$promise = $client->sendAsync($request)->then(function ($response) {
		    echo 'I completed! ' . $response->getBody();
		});

		$promise->wait(); */
    }
}