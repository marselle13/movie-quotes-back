<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct(public $user, public $verificationUrl)
	{
	}

	public function build(): Mailable
	{
		return $this->subject('Reset Your Password')
			->view('email.reset-password', [
				'user'            => $this->user,
				'verificationUrl' => $this->verificationUrl,
			]);
	}
}
