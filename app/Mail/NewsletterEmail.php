<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    protected $userData;

    public function __construct($user)
    {
        $this->userData = $user;
        $this->subject('U nas po nowemu! Zobacz co w Odziej się!');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userData = $this->userData;
        return $this->view('emails.newsletter_template', compact(['userData']));
    }
}
