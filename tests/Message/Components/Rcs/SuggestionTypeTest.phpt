<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';


/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\SuggestionType;

/**
 * @testCase
 */
class SuggestionTypeTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('reply', SuggestionType::Reply->value);
		Assert::same('dial_number', SuggestionType::DialNumber->value);
		Assert::same('view_location', SuggestionType::ViewLocation->value);
		Assert::same('share_location', SuggestionType::ShareLocation->value);
		Assert::same('open_url', SuggestionType::OpenUrl->value);
		Assert::same('create_calendar_event', SuggestionType::CreateCalendarEvent->value);

		Assert::count(6, SuggestionType::cases());
	}


	public function testSerialize(): void
	{
		Assert::same(['type' => 'reply', 'text' => 'text', 'postback' => 'ok'], SuggestionType::Reply->serialize(text: 'text'));
		Assert::same([
				'type' => 'dial_number',
				'text' => 'text',
				'postback' => 'ok',
				'phoneNumber' => '+420777777777',
			], SuggestionType::DialNumber->serialize(phone_number: '420777777777', text: 'text'));
		Assert::same([
				'type' => 'view_location',
				'text' => 'text',
				'postback' => 'ok',
				'location' => ['latitude' => '50', 'longitude' => '40', 'label' => null],
			], SuggestionType::ViewLocation->serialize(text: 'text', latitude: 50.0, longitude: 40.0));
		Assert::same(['type' => 'share_location', 'text' => 'text', 'postback' => 'ok'], SuggestionType::ShareLocation->serialize(text: 'text'));
		Assert::same(['type' => 'open_url', 'text' => 'text', 'postback' => 'ok', 'url' => 'url'], SuggestionType::OpenUrl->serialize(url: 'url', text: 'text'));
		Assert::same([
				'type' => 'create_calendar_event',
				'text' => 'text',
				'postback' => 'ok',
				'calendar' => [
					'start' => '2024-01-17T19:30:40Z',
					'end' => '2024-01-17T20:30:40Z',
					'title' => 'text',
					'description' => null,
					'timezone' => 'Europe/London',
				],
			], SuggestionType::CreateCalendarEvent->serialize(start: '2024-01-17T19:30:40Z', end: '2024-01-17T20:30:40Z', text: 'text'));
	}
}

(new SuggestionTypeTest())->run();
