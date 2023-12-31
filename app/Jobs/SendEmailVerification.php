<?php

namespace App\Jobs;

use App\Http\Controllers\VerifyEmailController;
use App\Mail\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 */
	public function __construct(public $user, public $infoMessage, public $locale, public $newEmail = null)
	{
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		Mail::to($this->newEmail ?? $this->user->email)->send((new VerifyEmail($this->user, $this->infoMessage, VerifyEmailController::generateVerificationUrl($this->user, $this->newEmail)))->locale($this->locale));
	}
}
