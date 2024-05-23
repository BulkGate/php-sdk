<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Settings\{Rcs, RcsText, RcsFile, RcsCard, RcsCarousel};

enum Variant
{
	case Text;
	case Message;
	case File;
	case Card;
	case Carousel;


	public function createSettings(mixed ...$settings): Rcs
	{
		unset($settings['variant']);

		return match ($this)
		{
			self::Text, self::Message => new RcsText(...$settings),
			self::File => new RcsFile(...$settings),
			self::Card => new RcsCard(...$settings),
			self::Carousel => new RcsCarousel(...$settings),
		};
	}
}
