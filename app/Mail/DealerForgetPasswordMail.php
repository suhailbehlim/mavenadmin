<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DealerForgetPasswordMail extends Mailable
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

        return $this->from('support@carsbn.com', 'CarsBN Dealer Forget Password')
            ->subject('Dealer Forget Password')
            ->markdown('mails.dealerForgetPasswordTemplate')
            ->with([
                'name' => session('mailDealerName'),
                'password' => session('mailDealerPassword')
            ]);

    }
}
