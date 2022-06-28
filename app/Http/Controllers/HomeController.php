<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return "With controller";
    }

    public function api()
    {
        return "With controller api";
    }
}
