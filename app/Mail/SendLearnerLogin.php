<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Learner;

class SendLearnerLogin extends Mailable
{
    use Queueable, SerializesModels;
    
    public $learner;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Learner $learner)
    {
        $this->learner = $learner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Access Learner Credentails')->markdown('mails.send_learner_login');
    }
}
