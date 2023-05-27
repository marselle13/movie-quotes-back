<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct($user, $verificationUrl)
	{
		$this->user = $user;
		$this->verificationUrl = $verificationUrl;
	}

	public function build()
	{
		return $this->subject('Verify Your Email')
				->view('email.confirmation', [
					'user'            => $this->user,
					'verificationUrl' => $this->verificationUrl,
				]);
	}
}
