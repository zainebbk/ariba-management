<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailFields extends Mailable
{
    use Queueable, SerializesModels;
    /**
     *Fields to modify.
     *
     *
     */
    public $fields=array();
    public $firstname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fields,$firstname)
    {
        $this->fields=$fields;
        $this->firstname=$firstname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($address = 'noreply@ariba.ma', $name = 'Ariba')
            ->view('admin.mains-admin.sales-agent.change-info-email')->subject("Complete your information to activate your account !");
    }
}
