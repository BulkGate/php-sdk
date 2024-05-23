<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
enum HeaderType: string
{
	case Image = 'image';

	case Video = 'video';

	case Text = 'text';

	case Location = 'location';


	public function createSettings(mixed ...$settings): Header
	{
		return match ($this)
		{
			self::Image, self::Video => new HeaderMedia(...$settings),
			self::Text => new HeaderText(...$settings),
			self::Location => new HeaderLocation(...$settings),
		};
	}
}
