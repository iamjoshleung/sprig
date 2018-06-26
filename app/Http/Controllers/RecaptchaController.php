<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecaptchaController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function verify(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'g-recaptcha-response' => $request->input('g-recaptcha-response'),
                'secret' => config('recaptcha.secret_key')
            ]
        ]);

        return response([], $res->getStatusCode());
    }
}
