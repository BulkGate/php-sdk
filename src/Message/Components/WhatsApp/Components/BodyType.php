<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
enum BodyType: string
{
	case Text = 'text';

	case Price = 'price';

	case Currency = 'currency';


	public function createSettings(mixed ...$settings): Body
	{
		return match ($this) {
			self::Price, self::Currency => new BodyPrice(...$settings),
			self::Text => new BodyText(...$settings),
		};
	}
}
