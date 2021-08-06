<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeRegister extends Mailable
{
    use Queueable, SerializesModels;
    /**
     *Fields to modify.
     *
     *
     */
    public $email;
    public $password;
    public $firstname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password,$firstname)
    {
        $this->email=$email;
        $this->password=$password;
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
            ->view('admin.mains-admin.mail.employee-create')->subject("Your account has been created successfully !");
    }
}
