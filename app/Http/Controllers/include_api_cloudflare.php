<?php

namespace App\Http\Controllers;

// use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class include_api_cloudflare extends Controller
{
    protected $client;
    protected $apiUrl = 'https://api.cloudflare.com/client/v4/';

       
        public function __construct()
        {
            $this->client = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                    'X-Auth-Key' => env('CLOUDFLARE_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
       
            ]);
           
        }
}
