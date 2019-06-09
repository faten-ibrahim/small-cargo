<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use URL;

class SupervisorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->token=str_random(32);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->view('emails.New_supervisor');
    // }

    public function build()
    {
        return $this->from('mail@example.com', 'Mailtrap')
            ->subject('Welcome to Cargo - مرحبا بك في كارجو')
            ->markdown('emails.New_supervisor')
            ->with([
                'name' => $this->name,
                'link' => url('/password/reset',$this->token).'?email='.urlencode($this->email)
            ]);
    }

}