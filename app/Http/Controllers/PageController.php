<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ReceiveFeedback;

class PageController extends Controller
{

    /**
     * 
     * 
     * @return 
     */
    public function index() {
        return view('index');
    }

    /**
     * 
     * 
     * @return 
     */
    public function getFeedback() {
        return view('feedback');
    }

    /**
     * 
     * 
     * @return 
     */
    public function postFeedback(ReceiveFeedback $request) {
        Mail::to(config('mail.to'))->send(new FeedbackSent($request->all()));
        return response()->json([], 204);
    }

    /**
     * 
     * 
     * @return 
     */
    public function about() {
        return view('about');
    }

    /**
     * 
     * 
     * @return 
     */
    public function servicePolicy() {
        return view('service-policy');
    }

    /**
     * 
     * 
     * @return 
     */
    public function termsOfService() {
        return view('terms-of-service');
    }

    /**
     * 
     * 
     * @return 
     */
    public function copyright() {
        return view('copyright');
    }
}
