<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProfileCoverletterRequest;
use App\Http\Requests\ProfileResumeUpdateRequest;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUploadAvatarRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['seeker','verified']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function users(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $users = Job::where('title','like','%'.$query.'%')
                ->orWhere('position','like','%'.$query.'%')
                ->get();
        return response()->json($users);
    }

    public function index(){
        $profile = Profile::where('user_id', Auth::id())->firstOrNew();
    	return view('profile.index', compact('profile'));
    }

    public function store(ProfileStoreRequest $request){

   		$user_id = auth()->user()->id;

      Profile::where('user_id',$user_id)->update([
        'address'=>$request->input('address'),
   			'experience'=>$request->input('experience'),
   			'bio'=>$request->input('bio'),
            'phone_number'=>$request->input('phone_number')
   		]);
   		return redirect()->back()->with('message','Profile Sucessfully Updated!');

   }

    public function coverletter(ProfileCoverletterRequest $request){

        $user_id = auth()->user()->id;
        $cover = $request->file('cover_letter')->store('public/files');
            Profile::where('user_id',$user_id)->update([
              'cover_letter'=>$cover
            ]);
            return redirect()->back()->with('message','Cover letter Sucessfully Updated!');

   }
    public function resume(ProfileResumeUpdateRequest $request){

          $user_id = auth()->user()->id;
          $resume = $request->file('resume')->store('public/files');
            Profile::where('user_id',$user_id)->update([
              'resume'=>$resume
            ]);
        return redirect()->back()->with('message','Resume Sucessfully Updated!');

   }

    public function avatar(ProfileUploadAvatarRequest $request){

        $user_id = auth()->user()->id;
        if($request->hasfile('avatar')){
            $file = $request->file('avatar');
            $ext =  $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/avatar/',$filename);
            Profile::where('user_id',$user_id)->update([
              'avatar'=>$filename
            ]);
        return redirect()->back()->with('message','Profile picture Sucessfully Updated!');
        }

   }

}
