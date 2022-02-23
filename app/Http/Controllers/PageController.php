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

    
}
