<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BackendController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
    	return view('admin.index');
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
    	return view('admin.ceate');
    }
}
