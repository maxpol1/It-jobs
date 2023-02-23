<?php

namespace App\Http\Controllers;


class BackendController extends Controller
{
    public function index(){
    	return view('admin.index');
    }

    public function create(){
    	return view('admin.ceate');
    }
}
