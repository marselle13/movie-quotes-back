<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(NotificationResource::collection(auth()->user()->notifications()->latest()->get()), 200);
	}
}
