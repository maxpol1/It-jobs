<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;

class FavouriteController extends Controller
{
    /**
     * @param $id
     * @return RedirectResponse
     */
    public function saveJob($id): RedirectResponse
    {
    	$jobId = Job::find($id);
    	$jobId->favorites()->attach(auth()->user()->id);
    	return redirect()->back();
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unSaveJob($id): RedirectResponse
    {
    	$jobId = Job::find($id);
    	$jobId->favorites()->detach(auth()->user()->id);
    	return redirect()->back();
    }
}
