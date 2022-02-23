<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public $api;

    public function __construct()
    {
        $this->api = config('star-wars.api');
    }

    public function index(){
        return Inertia::render('Dashboard', [
            "api" => $this->api,
        ]);
    }

    public function show($id){
        
        return Inertia::render('Film', [
            "api" => $this->api,
            "movieId" => $id,
        ]);
    }
    
}
