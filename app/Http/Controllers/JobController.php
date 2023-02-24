<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Post;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\JobPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class JobController extends Controller
{
    public function __construct(){
        $this->middleware(['employer','verified'],['except'=>array('index','show','apply','allJobs','searchJobs','category')]);
    }


    public function index(){
    	$jobs = Job::latest()->limit(10)->where('status',1)->get();
        $categories = Category::with('jobs')->get();
        $posts = Post::where('status',1)->get();
        $testimonial = Testimonial::orderBy('id','DESC')->first();

        $companies = Company::get()->random(12);

    	return view('welcome',compact('jobs','companies','categories','posts','testimonial'));
    }
    public function show($id,Job $job){

        $jobRecommendations = $this->jobRecommendations($job);

        return view('jobs.show',compact('job','jobRecommendations'));
    }

    public function jobRecommendations($job){
        $data = [];

        $jobsBasedOnCategories = Job::latest()->where('category_id',$job->category_id)
                             ->whereDate('last_date','>',date('Y-m-d'))
                             ->where('id','!=',$job->id)
                             ->where('status',1)
                             ->limit(6)
                             ->get();
        array_push($data,$jobsBasedOnCategories);

        $jobBasedOnCompany = Job::latest()
                                ->where('company_id',$job->company_id)
                                ->whereDate('last_date','>',date('Y-m-d'))
                                ->where('id','!=',$job->id)
                                ->where('status',1)
                                ->limit(6)
                                ->get();
            array_push($data,$jobBasedOnCompany);

        $jobBasedOnPosition= Job::where('position','LIKE','%'.$job->position.'%')                 ->where('id','!=',$job->id)
                                ->where('status',1)
                                ->limit(6);
            array_push($data,$jobBasedOnPosition);

       $collection  = collect($data);
       $unique = $collection->unique("id");
       $jobRecommendations =  $unique->values()->first();
       return $jobRecommendations;
    }



    public function company(){
    	return view('company.index');
    }

    public function myjob(){
        $jobs = Job::where('user_id',auth()->user()->id)->get();
        return view('jobs.myjob',compact('jobs'));
    }

    public function edit($id){
        $job = Job::findOrFail($id);
        return view('jobs.edit',compact('job'));
    }

    public function update(JobPostRequest $request,$id){
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return redirect()->back()->with('message','Job  Sucessfully Updated!');

    }
    public function applicant(){
        $applicants = Job::has('users')->where('user_id',auth()->user()->id)->get();
        return view('jobs.applicants',compact('applicants'));
    }


    public function  create(){

        return view('jobs.create');
    }
    public function  store(JobPostRequest $request){

        $user_id = Auth::id();
        $company = Company::where('user_id',$user_id)->first();
        $company_id = $company->id;
        Job::create([
            'user_id' => $user_id,
            'company_id' => $company_id,
            'title'=>$request->input('title'),
            'slug' =>Str::slug($request->input('title')),
            'description'=>$request->input('description'),
            'roles'=>$request->input('roles'),
            'category_id' =>$request->input('category'),
            'position'=>$request->input('position'),
            'address'=>$request->input('address'),
            'type'=>$request->input('type'),
            'status'=>$request->input('status'),
            'last_date'=>Carbon::parse($request->input('last_date')),
            'number_of_vacancy'=>$request->input('number_of_vacancy'),
            'gender'=>$request->input('gender'),
            'experience'=>$request->input('experience'),
            'salary'=>$request->input('salary')



        ]);
        return redirect()->back()->with('message','Job posted successfully!');
     }

     public function apply(Request $request,$id){
        $jobId = Job::find($id);
        $jobId->users()->attach(Auth::user()->id);
        return redirect()->back()->with('message','Application sent!');

    }

    public function allJobs(Request $request){

     //front search
        $search = $request->get('search');
        $address = $request->get('address');
        if($search && $address){
           $jobs = Job::where('position','LIKE','%'.$search.'%')
                    ->orWhere('title','LIKE','%'.$search.'%')
                    ->orWhere('type','LIKE','%'.$search.'%')
                    ->orWhere('address','LIKE','%'.$address.'%')
                    ->paginate(20);

            return view('jobs.alljobs',compact('jobs'));

        }




       $keyword = $request->get('position');
       $type = $request->get('type');
       $category = $request->get('category_id');
       $address = $request->get('address');
       if($keyword||$type||$category||$address){
        $jobs = Job::where('position','LIKE','%'.$keyword.'%')
                ->orWhere('type',$type)
                ->orWhere('category_id',$category)
                ->orWhere('address',$address)
                ->paginate(20);
                return view('jobs.alljobs',compact('jobs'));
       }else{

            $jobs = Job::latest()->paginate(20);
            return view('jobs.alljobs',compact('jobs'));
    }


}
    public function searchJobs(Request $request){

        $keyword = $request->get('keyword');
        $users = Job::where('title','like','%'.$keyword.'%')
                ->orWhere('position','like','%'.$keyword.'%')
                ->limit(5)->get();
        return response()->json($users);

    }



}
