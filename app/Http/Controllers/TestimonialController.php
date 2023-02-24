<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;


class TestimonialController extends Controller
{
	public function index(){
		$testimonials = Testimonial::paginate(10);
		return view('testimonial.index',compact('testimonials'));
	}

    public function create(){
    	return view('testimonial.create');
    }

    public function store(TestimonialStoreRequest $request){

    	Testimonial::create([
    		'content'=>$request->get('content'),
    		'name'=>$request->get('name'),
    		'profession'=>$request->get('profession'),
    		'video_id'=>$request->get('video_id')
    	]);
    	return redirect()->back()->with('message','Testimonila created successfully');


    }


}
