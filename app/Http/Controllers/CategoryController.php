<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class CategoryController extends Controller
{
    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function index($id): Factory|View|Application
    {
        $jobs = Job::where('category_id', $id)->paginate(20);
        $categoryName = Category::where('id', $id)->first();


        return view('jobs.jobs-category', compact('jobs', 'categoryName'));
    }
}
