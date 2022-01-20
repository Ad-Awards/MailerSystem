<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNewsletter;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $emails_address = [
            0 => 'd.plociennik@adawards.pl',
            // 1 => 'k.zygadlo@adawards.pl',
            // 2 => 'd.lewicki@adawards.pl',
            // 3 => '4p.koper@adawards.pl',
        ];

        foreach ($emails_address as $key => $value) {
            try {
                ProcessNewsletter::dispatch($key, $value)->delay(now()->addSeconds(2));
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }

    public function angryBirds(string $token)
    {
        $data = [
            'token' => $token
        ];
        return view('front.cancel', compact(['data']));
    }

    public function removeSubscription(Request $request)
    {
        $getUser = DB::table('newsletters')->where('token', $request->userToken)->first();
        if (empty($getUser)) {
            echo 'Nie ma takiego użytkownika <img src=' . asset("assets/img/cancel-user.png") . ' width="64">';
            Log::notice('Brak użytkownika z tokenem ' . $request->userToken);
            return;
        } else if ($getUser->active == 0) {
            echo 'Ten użytkownik anulował już swoją subskrypcje <img src=' . asset("assets/img/renew.png") . ' width="64">';
            Log::notice('Użytkownik ' . $getUser->email . ' z tokenem ' . $request->userToken . ' anulował już swoją subskrypcje');
            return;
        } else {
            $data = [
                'active' => 0
            ];
            $query = DB::table('newsletters')->where('token', $request->userToken)->update($data);
            if ($query) {
                echo 'Twoja subskrypcja została pomyślnie anulowana <img src=' . asset("assets/img/check.png") . ' width="64">';
                Log::notice('Subskrypcja użytkownika ' . $getUser->email . ' z tokenem ' . $request->userToken . ' została anulowana');
                return;
            } else {
                echo 'Nie mogliśmy anulować Twojej subskrypcji. Skontaktuj się z administracją <img src=' . asset("assets/img/close.png") . ' width="64">';
                Log::notice('Błąd anulowania subskrypcji użytkownikowi ' . $getUser->email . ' z tokenem ' . $request->userToken);
                return;
            }
        }
    }
}
