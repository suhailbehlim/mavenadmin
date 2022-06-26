<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserUpdatePassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $mailData;


    public function __construct($mailData)
    {
        //

        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailInfo =  $this->mailData;

        return $this->from('support@carsbn.com', 'CarsBN Forget Password')
        ->subject('Password Changed')
        ->markdown('mails.userPasswordSuccessTemplate')
        ->with([
            'name' => $mailInfo['name'],
            'password' => $mailInfo['password'],
            'email' => $mailInfo['email']
        ]);
    }
}
