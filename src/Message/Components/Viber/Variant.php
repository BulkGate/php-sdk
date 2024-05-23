<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Viber;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Settings\{ViberCard, Viber, ViberText};

enum Variant
{
	case Text;
	case Card;

	public function createSettings(mixed ...$settings): Viber
	{
		unset($settings['variant']);


		return match ($this)
		{
			self::Text => new ViberText(...$settings),
			self::Card => new ViberCard(...$settings),
		};
	}
}
