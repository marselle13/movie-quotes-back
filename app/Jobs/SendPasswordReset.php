<?php

namespace App\Jobs;

use App\Http\Controllers\ResetPasswordController;
use App\Mail\ResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordReset implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 */
	public function __construct(public $user, public $token, public $locale)
	{
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		Mail::to($this->user->email)->send((new ResetPasswordMail($this->user, ResetPasswordController::generateResetPasswordUrl($this->user, $this->token)))->locale($this->locale));
	}
}
