<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Job;

class CompanyController extends Controller
{
  public function __construct(){
        $this->middleware(['employer'],['except'=>array('index','company')]);
    }


    /**
     * @param $id
     * @param Company $company
     * @return Factory|View|Application
     */
    public function index($id, Company $company): Factory|View|Application
    {
    	$jobs = Job::where('user_id',$id)->get();
    	return view('company.index',compact('company'));
    }

    /**
     * @return Factory|View|Application
     */
    public function company(): Factory|View|Application
    {
      $companies = Company::latest()->simplePaginate(20);
      return view('company.company',compact('companies'));
    }


    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
    	return view('company.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
   		$user_id = auth()->user()->id;

      Company::where('user_id',$user_id)->update([
        'address'=>$request->input('address'),
   			'phone'=>$request->input('phone'),
   			'website'=>$request->input('website'),
   			'slogan'=>$request->input('slogan'),
   			'description'=>$request->input('description')
   		]);
   		return redirect()->back()->with('message','Company Sucessfully Updated!');

   }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function coverPhoto(Request $request): RedirectResponse
    {
        $user_id = auth()->user()->id;
        if($request->hasfile('cover_photo')){

            $file = $request->file('cover_photo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/coverphoto/', $filename);
            Company::where('user_id',$user_id)->update([
                'cover_photo'=>$filename
            ]);
        }
        return redirect()->back()->with('message','Company coverphoto Sucessfully Updated!');

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function companyLogo(Request $request): RedirectResponse
    {
        $user_id = auth()->user()->id;
        if($request->hasfile('company_logo')){

            $file = $request->file('company_logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/logo/',$filename);
            Company::where('user_id',$user_id)->update([
                'logo'=>$filename
            ]);
        }
        return redirect()->back()->with('message','Company logo Sucessfully Updated!');

    }



}
