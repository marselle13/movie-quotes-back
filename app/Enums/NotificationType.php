<?php

namespace App\Enums;

enum NotificationType: string
{
	case COMMENT = 'commented';
	case NEW = 'new';
}
