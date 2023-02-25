<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailSendRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendJob;


class EmailController extends Controller
{
    /**
     * @param EmailSendRequest $request
     * @return RedirectResponse
     */
    public function send(EmailSendRequest $request): RedirectResponse
    {

        $homeUrl = url('/');
        $jobId = $request->get('job_id');
        $jobSlug = $request->get('job_slug');

        $jobUrl = $homeUrl . '/' . 'jobs/' . $jobId . '/' . $jobSlug;

        $data = array(
            'your_name' => $request->get('your_name'),
            'your_email' => $request->get('your_email'),
            'friend_name' => $request->get('friend_name'),
            'jobUrl' => $jobUrl
        );

        $emailTo = $request->get('friend_email');
        try {
            Mail::to($emailTo)->send(new SendJob($data));
            return redirect()->back()->with('message', 'Job link sent to ' . $emailTo);

        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', $e->getMessage());

        }


    }
}
