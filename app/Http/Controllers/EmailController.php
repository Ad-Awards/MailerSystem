<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNewsletter;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class EmailController extends Controller
{

    public function testEmail()
    {
        $email_address = 'i.kruczek@adawards.pl';
        $data = [
            'last_send_data' => date('Y-m-d H:i:s'),
            'first_name' => '',
            'last_name' => '',
            'email' => $email_address,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus minima totam accusantium. Impedit sequi similique at consequatur eveniet vitae ab hic, dolore amet dolor dignissimos rem exercitationem porro saepe nam?',
            'token' => Str::random(32)
        ];
        try {
            $email = new NewsletterEmail($data);
            Mail::to($email_address)->send($email);
        } catch (\Exception $e) {
            print_r($e);
        }
    }

    public function sendEmail()
    {
        $emails_address = [];
        // plik CSV z 270 tys. rekordów (przy 50 000 się wywala skrypt (timeout max 60s))
        foreach ($this->fetchCSV('emails_2.csv') as $key => $value) {
            array_push($emails_address, substr($value['email'], 0, -1));
            // podzielenie CSVki
        }
        foreach ($emails_address as $key => $value) {
            try {
                ProcessNewsletter::dispatch($key, $value)->delay(now()->addSeconds(2));
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }

    public function insertMailsToDatabase()
    {
        foreach ($this->fetchCSV('emails_1.csv') as $key => $value) {
            $email_address = substr($value['email'], 0, -1);
            $getUser = DB::connection('mysql2')->table('newsletters')->where('email', $email_address)->first();
            dd($getUser);
            $data = [
                'last_send_data' => date('Y-m-d H:i:s'),
                'first_name' => '',
                'last_name' => '',
                'email' => $email_address,
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus minima totam accusantium. Impedit sequi similique at consequatur eveniet vitae ab hic, dolore amet dolor dignissimos rem exercitationem porro saepe nam?',
                'token' => Str::random(32)
            ];

            if (empty($getUser)) {
                DB::connection('mysql2')->table('newsletters')->insert($data);
                dd($data);
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

    public function fetchCSV(string $filename)
    {
        try {
            return (new FastExcel)->import('csv/' . $filename);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
