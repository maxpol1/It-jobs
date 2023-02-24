<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {

    	$posts = Post::latest()->paginate(20);
    	return view('admin.index',compact('posts'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
    	return view('admin.create');
    }

    /**
     * @param PostStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {

   		if($request->hasFile('image')){
   			$file = $request->file('image');
   			$path = $file->store('uploads','public');
   			Post::create([
   				'title'=>$title=$request->get('title'),
   				'slug'=>Str::slug($title),
   				'content'=>$request->get('content'),
   				'image'=>$path,
   				'status'=>$request->get('status')
   			]);
   		}
   		return to_route('admin_dashboard')->with('message','Post created successfully');
   }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function edit($id): Factory|View|Application
    {
   		$post = Post::find($id);
   		return view('admin.edit',compact('post'));
    }

    /**
     * @param $id
     * @param PostUpdateRequest $request
     * @return RedirectResponse
     */
    public function update($id, PostUpdateRequest $request): RedirectResponse
    {

    	if($request->hasFile('image')){
   			$file = $request->file('image');
   			$path = $file->store('uploads','public');
   			Post::where('id',$id)->update([
   				'title'=>$title=$request->get('title'),
   				'content'=>$request->get('content'),
   				'image'=>$path,
   				'status'=>$request->get('status')
   			]);
   		}

   		$this->updateAllExceptImage($request,$id);
   		return redirect()->back()->with('message','Post updated successfully');

    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateAllExceptImage(Request $request, $id){
    	return Post::where('id',$id)->update([
   				'title'=>$title=$request->get('title'),
   				'content'=>$request->get('content'),
   				'status'=>$request->get('status')
   			]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {

   		$id = $request->get('id');
   		$post = Post::find($id);
   		$post->delete();
   		return redirect()->back()->with('message','Post deleted successfully');
    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
    	Post::onlyTrashed()->where('id',$id)->restore();
        return redirect()->back()->with('message','Post restored successfully');

    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function toggle($id): RedirectResponse
    {
    	$post = Post::find($id);
    	$post->status = !$post->status;
    	$post->save();
    	return redirect()->back()->with('message','Status updated successfully');

    }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function show($id): Factory|View|Application
    {
      $post = Post::find($id);
      return view('admin.read',compact('post'));
    }

    /**
     * @return Factory|View|Application
     */
    public function getAllJobs(): Factory|View|Application
    {
        $jobs = Job::latest()->paginate(50);
        return view('admin.job',compact('jobs'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function changeJobStatus($id): RedirectResponse
    {
        $job = Job::find($id);
        $job->status = !$job->status;
        $job->save();
        return redirect()->back()->with('message','Status updated successfully');
    }





}
