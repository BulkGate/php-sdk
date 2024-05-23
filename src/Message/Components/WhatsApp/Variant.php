<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Settings\{WhatsApp, WhatsAppMessage, WhatsAppFile, WhatsAppTemplate, WhatsAppLocation, WhatsAppOtp};

enum Variant
{
	case Text;

	case Otp;

	case File;

	case Location;

	case Template;


	public function createSettings(mixed ...$settings): WhatsApp
	{
		unset($settings['variant']);

		return match ($this)
		{
			self::Text => new WhatsAppMessage(...$settings),
			self::Otp => new WhatsAppOtp(...$settings),
			self::File => new WhatsAppFile(...$settings),
			self::Location => new WhatsAppLocation(...$settings),
			self::Template => new WhatsAppTemplate(...$settings),
		};
	}
}
