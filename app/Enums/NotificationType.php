<?php

namespace App\Enums;

enum NotificationType: string
{
	case COMMENT = 'commented';
	case LIKE = 'liked';
	case NEW = 'new';
	case SEEN = 'seen';
}
