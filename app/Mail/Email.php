<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $comp;
    public $siteSetting;

    public function __construct($comp, $siteSetting)
    {
        //
        $this->comp = $comp;
        $this->siteSetting = $siteSetting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.email', ['msg' => $this->comp, 'sitesetting' => $this->siteSetting]);
    }
}
