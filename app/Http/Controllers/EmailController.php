<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNewsletter;
use App\Mail\NewsletterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail() {
        
        // $email = new NewsletterEmail();
        // Mail::to("dawid.plociennik13@gmail.com")->send($email);

        Log::info('Send email to dawid.plociennik13@gmail.com');
        try {
            for ($i=0; $i < 100 ; $i++) { 
                ProcessNewsletter::dispatch();
            }
            Log::debug('Successfull send email to dawid.plociennik13@gmail.com');
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
