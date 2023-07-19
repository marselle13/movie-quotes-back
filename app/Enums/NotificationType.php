<?php

namespace App\Enums;

enum NotificationType: string
{
	case NEW = 'new';
	case SEEN = 'seen';
}
