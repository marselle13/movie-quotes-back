<?php

namespace App\Enums;

enum NotificationType: string
{
	case COMMENT = 'Commented to your movie quote';
	case LIKE = 'Reacted to your quote';
}
