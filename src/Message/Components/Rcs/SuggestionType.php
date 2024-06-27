<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\InvalidStateException;
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\{CreateCalendarEvent, DialNumber, OpenUrl, Reply, ShareLocation, ViewLocation};

enum SuggestionType: string
{
	case Reply = 'reply';
	case DialNumber = 'dial_number';
	case ViewLocation = 'view_location';
	case ShareLocation = 'share_location';
	case OpenUrl = 'open_url';
	case CreateCalendarEvent = 'create_calendar_event';


	/**
	 * @param mixed ...$settings
	 * @return array<string|int, mixed>
	 * @throws InvalidStateException
	 */
	public function serialize(mixed ...$settings): array
	{
		$suggestion = match ($this)
		{
			self::Reply => new Reply(...$settings),
			self::DialNumber => new DialNumber(...$settings),
			self::ViewLocation => new ViewLocation(...$settings),
			self::ShareLocation => new ShareLocation(...$settings),
			self::OpenUrl => new OpenUrl(...$settings),
			self::CreateCalendarEvent => new CreateCalendarEvent(...$settings),
		};

		return $suggestion->serialize();
	}
}
