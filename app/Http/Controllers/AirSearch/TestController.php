<?php

namespace App\Http\Controllers\AirSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function Test(){
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        $jsonData = $response->json();
        // dd($jsonData);
    }
}
