<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('support@carsbn.com', 'CarsBN Admin Forget Password')
            ->subject('Admin Forget Password')
            ->markdown('mails.adminForgetPasswordTemplate')
            ->with([
                'name' => session('mailAdminName'),
                'password' => session('mailAdminPassword')
            ]);

    }
}
