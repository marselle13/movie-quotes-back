<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResoruce;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(NotificationResoruce::collection(auth()->user()->notifications()->latest()->get()), 200);
	}
}
