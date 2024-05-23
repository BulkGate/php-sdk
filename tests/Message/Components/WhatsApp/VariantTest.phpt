<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\{Components\BodyType, Components\HeaderType, Variant};
use BulkGate\Sdk\Message\Settings\{WhatsAppMessage, WhatsAppOtp, WhatsAppFile, WhatsAppLocation, WhatsAppTemplate};

/**
 * @testCase
 */
class VariantTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::type(WhatsAppMessage::class, Variant::Text->createSettings());
		Assert::type(WhatsAppOtp::class, Variant::Otp->createSettings(code: '0451'));
		Assert::type(WhatsAppFile::class, Variant::File->createSettings());
		Assert::type(WhatsAppLocation::class, Variant::Location->createSettings(latitude: 50.0, longitude: 40.0));
		Assert::type(WhatsAppTemplate::class, Variant::Template->createSettings(
			header: HeaderType::Text->createSettings(type: HeaderType::Text, text: 'text'),
			body: BodyType::Text->createSettings(type: BodyType::Text, text: 'text'),
			template: 'xxx'
		));

		Assert::count(5, Variant::cases());
	}
}

(new VariantTest())->run();
