<?php

namespace App\Jobs;

use App\Mail\NewsletterEmail;
use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProcessNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $id;
    protected $email_address;

    public function __construct(int $id, string $email_address)
    {
        $this->id = $id;
        $this->email_address = $email_address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Config::set('mail.mailers.smtp.host', 'test2');
        // Config::set('mail.mailers.smtp.port', 587);
        // Config::set('mail.mailers.smtp.username', '');
        // Config::set('mail.mailers.smtp.password', '');

        try {

            $getUser = DB::table('newsletters')->where('email', $this->email_address)->first();
            if (!empty($getUser) && $getUser->active == 0) {
                Log::warning('['.$this->id.'] User with e-mail ' . $this->email_address . ' refuse newsletter');
                return;
            }

            $data = [
                'last_send_data' => date('Y-m-d H:i:s'),
                'first_name' => '',
                'last_name' => '',
                'email' => $this->email_address,
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus minima totam accusantium. Impedit sequi similique at consequatur eveniet vitae ab hic, dolore amet dolor dignissimos rem exercitationem porro saepe nam?',
                'token' => Str::random(32)
            ];

            if (empty($getUser)) {
                DB::table('newsletters')->insert($data);
                $logInfo = 'insert new record';
            } else {
                DB::table('newsletters')->where('email', $this->email_address)->update($data);
                $logInfo = 'updated record';
            }

            $email = new NewsletterEmail($data);
            Mail::to($this->email_address)->send($email);

            Log::info('['.$this->id.'] Send e-mail to ' . $this->email_address . ' and ' . $logInfo);

        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
