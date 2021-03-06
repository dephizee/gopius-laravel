<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Instructor;
class SendInstructorLogin extends Mailable
{
    use Queueable, SerializesModels;

    public $instructor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Instructor $instructor)
    {
        $this->instructor = $instructor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Access Instructor Credentails')->markdown('mails.send_instructor_login');
    }
}
