<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function __construct() {
        $this->middleware('auth.admin');
    }

    /**
     * 
     * 
     * @return 
     */
    public function index() {
        return view('cm.index');
    }
}
