<?php

namespace App\Enums;

enum NotificationMessage: string
{
	case COMMENT = 'commented';
	case LIKE = 'liked';
}
