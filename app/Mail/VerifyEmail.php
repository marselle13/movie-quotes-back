<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
	use Queueable, SerializesModels;

	protected string $info;

	public function __construct(public $user, public $verificationUrl)
	{
		if ($this->user->created_at === $this->user->updated_at) {
			$this->info = 'Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:';
		} else {
			$this->info = 'Your Email Changed Successfully. Please click the button below to verify your account:';
		}
	}

	public function build(): Mailable
	{
		return $this->subject('Verify Your Email')
				->view('email.confirmation', [
					'user'            => $this->user,
					'verificationUrl' => $this->verificationUrl,
					'info'            => $this->info,
				]);
	}
}
