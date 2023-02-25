<?php

    namespace App\Http\Controllers;

    use Illuminate\Contracts\Support\Renderable;
    use Illuminate\Support\Facades\Auth;

    class HomeController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * Show the application dashboard.
         *
         * @return Renderable
         */
        public function index()
        {
            if (auth()->user()->user_type == 'employer') {
                return redirect()->to('/company/create');
            }
            $adminRole = Auth::user()->roles()->pluck('name');
            if ($adminRole->contains('admin')) {
                return to_route('admin_dashboard');
            }


            $jobs = Auth::user()->favorites;
            return view('home', compact('jobs'));
        }
    }
