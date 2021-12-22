<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\users\RegisterController;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;


    public function __construct($data)
    {
        $this->name = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->name;
        // dd($user);
        return $this->view('emails.welcome', compact('user'));
    }
}
