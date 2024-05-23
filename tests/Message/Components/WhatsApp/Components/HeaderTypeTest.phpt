<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\HeaderType;


/**
 * @testCase
 */
class HeaderTypeTest extends TestCase
{
	public function testFileType(): void
	{
		Assert::same([
			'type' => HeaderType::Image->value,
			'url' => 'url',
			'caption' => 'caption'
		], HeaderType::Image->createSettings(type: HeaderType::Image, url: 'url', caption: 'caption')->serialize());
		Assert::same([
			'type' => HeaderType::Text->value,
			'text' => 'text',
		], HeaderType::Text->createSettings(type: HeaderType::Text, text: 'text')->serialize());
		Assert::same([
			'type' => HeaderType::Location->value,
			'location' => [
				'latitude' => 50.0,
				'longitude' => 40.0,
				'name' => 'Karluv most',
				'address' => 'Karluv most'
			]
		], HeaderType::Location->createSettings(type: HeaderType::Location, latitude: 50.0, longitude: 40.0, name: 'Karluv most', address: 'Karluv most')->serialize());
		Assert::same([
			'type' => HeaderType::Video->value,
			'url' => 'url',
			'caption' => 'caption'
		], HeaderType::Video->createSettings(type: HeaderType::Video, url: 'url', caption: 'caption')->serialize());
	}
}

(new HeaderTypeTest())->run();
