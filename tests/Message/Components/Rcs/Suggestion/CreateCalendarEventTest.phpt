<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Nette\Utils\DateTime;
use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\CreateCalendarEvent;


/**
 * @testCase
 */
class CreateCalendarEventTest extends TestCase
{
	public function testAction(): void
	{
		Assert::equal([
			'type' => 'create_calendar_event',
			'text' => 'Create event',
			'postback' => 'postback',
			'calendar' => [
				'start' => '2024-01-17T19:30:40Z',
				'end' => '2024-01-17T20:30:40Z',
				'title' => 'title',
				'description' => 'description',
				'timezone' => 'Europe/Prague',
			],

		], (new CreateCalendarEvent('2024-01-17 20:30:40', null, 'Create event', 'postback', 'title', 'description', 'fallback', 'Europe/Prague'))->serialize());

		Assert::equal([
			'type' => 'create_calendar_event',
			'text' => 'Create event',
			'postback' => 'postback',
			'calendar' => [
				'start' => '2024-01-17T10:20:12Z',
				'end' => '2024-01-17T10:20:17Z',
				'title' => 'title',
				'description' => 'description',
				'timezone' => 'Europe/Bratislava',
			],
		], (new CreateCalendarEvent(1705486812, 1705486817, 'Create event', 'postback', 'title', 'description', 'fallback', 'Europe/Bratislava'))->serialize());


		Assert::equal([
			'type' => 'create_calendar_event',
			'text' => 'Create event',
			'postback' => 'postback',
			'calendar' => [
				'start' => '2024-01-17T10:20:12Z',
				'end' => '2024-01-17T11:20:12Z',
				'title' => 'title',
				'description' => 'description',
				'timezone' => 'Europe/Bratislava',
			],
		], (new CreateCalendarEvent(1705486812, null, 'Create event', 'postback', 'title', 'description', 'fallback', 'Europe/Bratislava'))->serialize());


		Assert::equal([
			'type' => 'create_calendar_event',
			'text' => 'Create event',
			'postback' => 'postback',
			'calendar' => [
				'start' => '2024-01-17T10:20:12Z',
				'end' => '2024-01-17T10:20:12Z',
				'title' => 'title',
				'description' => 'description',
				'timezone' => 'Europe/Prague',
			],
		], (new CreateCalendarEvent('2024-01-17T10:20:12Z', new DateTime('2024-01-17T10:20:12Z'), 'Create event', 'postback', 'title', 'description', 'fallback', 'Europe/Prague'))->serialize());


		Assert::equal([
			'type' => 'create_calendar_event',
			'text' => 'Create event',
			'postback' => 'postback',
			'calendar' => [
				'start' => '2024-01-17T10:20:12Z',
				'end' => '2024-01-17T11:20:12Z',
				'title' => 'title',
				'description' => 'description',
				'timezone' => 'Europe/Prague',
			],
		], (new CreateCalendarEvent('2024-01-17T10:20:12Z', null, 'Create event', 'postback', 'title', 'description', 'fallback', 'Europe/Prague'))->serialize());
	}
}

(new CreateCalendarEventTest())->run();
