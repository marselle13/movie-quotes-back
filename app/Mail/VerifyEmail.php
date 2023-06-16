<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct(public $user, public $infoMessage, public $verificationUrl)
	{
	}

	public function build(): Mailable
	{
		return $this->subject('Verify Your Email')
				->view('email.confirmation', [
					'user'            => $this->user,
					'verificationUrl' => $this->verificationUrl,
					'info'            => $this->infoMessage,
				]);
	}
}
