<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;


class CategoryController extends Controller
{
    public function index($id)
    {
        $jobs = Job::where('category_id', $id)->paginate(20);
        $categoryName = Category::where('id', $id)->first();


        return view('jobs.jobs-category', compact('jobs', 'categoryName'));
    }
}
