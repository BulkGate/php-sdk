<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\InvalidStateException;
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\ViewLocation;

/**
 * @testCase
 */
class ViewLocationTest extends TestCase
{
	public function testAction(): void
	{
		Assert::same([
			'type' => 'view_location',
			'text' => 'button_text',
			'postback' => 'postback',
			'location' => [
				'latitude' => '51.2366',
				'longitude' => '0.5704',
				'label' => 'address',
			],
		], (new ViewLocation('button_text', 'postback', latitude: 51.2366, longitude: 0.5704, query: 'query', label: 'address'))->serialize());

		Assert::same([
			'type' => 'view_location',
			'text' => 'button_text',
			'postback' => 'postback',
			'location' => ['query' => 'query', 'label' => 'address'],
		], (new ViewLocation('button_text', 'postback', latitude: null, longitude: 0.5704, query: 'query', label: 'address'))->serialize());

		Assert::same([
			'type' => 'view_location',
			'text' => 'button_text',
			'postback' => 'postback',
			'location' => ['query' => 'query', 'label' => 'address'],
		], (new ViewLocation('button_text', 'postback', 51.2366, null, 'query', label: 'address'))->serialize());

		Assert::exception(fn() => (new ViewLocation('button_text', 'postback', latitude: null, longitude: null, query: null, label: 'address'))->serialize(), InvalidStateException::class, 'view_location_action_missing_location');
	}
}

(new ViewLocationTest())->run();
