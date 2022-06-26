<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;



class WelcomeUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // if(session('name') !='') {
        //     $name =  session('name');
        // } else {
        //     $name =  Auth::user()->name;
        // }
        
        return $this->from('support@btntlee.com', 'Welcome Mail')
        ->subject('Welcome to Blntlee')
        ->markdown('mails.welcomeMail')
        ->with([
            'name' =>  $this->data['name'] ,
            'username' =>  $this->data['username'] ,
            //'password' => session('password'),
            //'email' =>  session('email'),
        ]);


    }
}
