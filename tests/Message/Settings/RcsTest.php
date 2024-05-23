<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\Rcs\Alignment, Sdk\Message\Component\Rcs\Card, Sdk\Message\Component\Rcs\Height, Sdk\Message\Component\Rcs\Orientation, Sdk\Message\Component\Rcs\Suggestion\DialNumber, Sdk\Message\Component\Rcs\Suggestion\ViewLocation, Sdk\Message\Component\Rcs\Width,
	Sdk\Message\Settings\RcsCard, Sdk\Message\Settings\RcsCarousel, Sdk\Message\Settings\RcsFile, Sdk\Message\Settings\RcsText};
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class RcsTest extends TestCase
{
	public function testText(): void
	{
		$rcs = new RcsText(text: $text = 'text', sender: $sender = 'BulkGate', timeout: $timeout = 65, suggestions: $suggestion = [
			new ViewLocation(
				text: 'text',
				latitude: 50.0,
				longitude: 50.0
			)
		]);

		Assert::same($text, $rcs->text);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);

		Assert::same('{"sender":"BulkGate","expiration":65,"message":{"text":"text","suggestions":[{"type":"view_location","text":"text","postback":"ok","location":{"latitude":"50","longitude":"50","label":null}}]}}',
			json_encode($rcs)
		);

		// Restrict rewrite
		$rcs->configure('rcs', 'TOPefekt', 65);

		Assert::same($text, $rcs->text);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);

		$rcs->configure(channel: 'rcs', sender: 'TOPefekt', timeout: 65);

		Assert::same($text, $rcs->text);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);
	}


	public function testFile(): void
	{
		$rcs = new RcsFile(url: $url = 'url_text', force_refresh: true, sender: $sender = 'TOPefekt', timeout: $timeout = 65, suggestions: $suggestion = [
			new DialNumber(
				phone_number: '420777777777',
				text: 'text',
			)
		]);

		Assert::same($url, $rcs->url);
		Assert::true($rcs->force_refresh);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);

		Assert::same('{"sender":"TOPefekt","expiration":65,"file":{"url":"url_text","force_refresh":true,"suggestions":[{"type":"dial_number","text":"text","postback":"ok","phoneNumber":"+420777777777"}]}}',
			json_encode($rcs)
		);

		// Restrict rewrite
		$rcs->configure('rcs', 'TOPefekt', 65);

		Assert::same($url, $rcs->url);
		Assert::true($rcs->force_refresh);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);

		$rcs->configure(channel: 'rcs', sender: 'TOPefekt', timeout: 65, force_refresh: false);

		Assert::true($rcs->force_refresh);
		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($suggestion, $rcs->suggestions);
	}


	public function testCarousel(): void
	{
		$rcs = new RcsCarousel(sender: $sender = 'TOPefekt', cards: [
			$card = new Card(
				title: 'title',
				description: 'description',
				alignment: Alignment::Left,
				orientation: Orientation::Horizontal,
				file_url: 'file_url',
				file_refresh: false,
				height: Height::Tall,
				suggestions: [
					new ViewLocation(
						text: 'text',
						postback: 'ok',
						latitude: 50.0,
						longitude: 40.0,
						query: 'Karluv most',
						label: 'Karluv most',
					),
				],
			),
		], width: $width = Width::Medium, timeout: $timeout = 65);


		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($width, $rcs->width);
		Assert::same([$card], $rcs->cards);

		Assert::same('{"sender":"TOPefekt","expiration":65,"carousel":{"width":"MEDIUM","cards":[{"title":"title","description":"description","orientation":"HORIZONTAL","alignment":"LEFT","suggestions":[{"type":"view_location","text":"text","postback":"ok","location":{"latitude":"50","longitude":"40","label":"Karluv most"}}],"media":{"height":"TALL","url":"file_url","forceRefresh":false}}]}}',
			json_encode($rcs)
		);

		// Restrict rewrite
		$rcs->configure('rcs', 'TOPefekt', 65);

		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);


		$rcs->configure(channel: 'rcs', sender: 'TOPefekt', timeout: 65);


		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);


		$rcs = new RcsCarousel(sender: 'TOPefekt', cards: [
			new Card(
				title: 'title',
				description: 'description',
				alignment: null,
				orientation: null,
				file_url: 'file_url',
				file_refresh: false,
				height: Height::Tall,
				suggestions: [
					new ViewLocation(
						text: 'text',
						postback: 'ok',
						latitude: 50.0,
						longitude: 40.0,
						query: 'Karluv most',
						label: 'Karluv most',
					),
				],
			),
		], width: null, timeout: null);

		Assert::same('{"sender":"TOPefekt","expiration":60,"carousel":{"width":null,"cards":[{"title":"title","description":"description","orientation":null,"alignment":null,"suggestions":[{"type":"view_location","text":"text","postback":"ok","location":{"latitude":"50","longitude":"40","label":"Karluv most"}}],"media":{"height":"TALL","url":"file_url","forceRefresh":false}}]}}',
			json_encode($rcs)
		);
	}


	public function testCard(): void
	{
		$rcs = new RcsCard(
			title: $title = 'title',
			description: $desctiption = 'description',
			url: $url = 'url',
			sender: $sender = 'TOPefekt',
			force_refresh: false,
			height: $height = Height::Tall,
			suggestions: $suggestions = [
				new ViewLocation(
					text: 'text',
					postback: 'ok',
					latitude: 50.0,
					longitude: 40.0,
					query: 'Karluv most',
					label: 'Karluv most',
				),
			],
			timeout: $timeout = 65
		);

		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
		Assert::same($title, $rcs->title);
		Assert::same($desctiption, $rcs->description);
		Assert::same($url, $rcs->url);
		Assert::same($height, $rcs->height);
		Assert::same($suggestions, $rcs->suggestions);
		Assert::false($rcs->force_refresh);


		Assert::same('{"sender":"TOPefekt","expiration":65,"card":{"title":"title","description":"description","orientation":null,"alignment":null,"suggestions":[{"type":"view_location","text":"text","postback":"ok","location":{"latitude":"50","longitude":"40","label":"Karluv most"}}],"media":{"height":"TALL","url":"url","forceRefresh":false}}}',
			json_encode($rcs)
		);

		// Restrict rewrite
		$rcs->configure('rcs', 'TOPefekt', 65);

		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);

		$rcs->configure(channel: 'rcs', sender: 'TOPefekt', timeout: 65);

		Assert::same($sender, $rcs->sender);
		Assert::same($timeout, $rcs->timeout);
	}


	public function testConfigure(): void
	{
		$rcs = new RcsText(text: 'text', suggestions: [
			new ViewLocation(
				text: 'text',
				latitude: 50.0,
				longitude: 50.0
			)
		]);

		Assert::null($rcs->sender);
		Assert::null($rcs->timeout);

		Assert::same('{"sender":"","expiration":60,"message":{"text":"text","suggestions":[{"type":"view_location","text":"text","postback":"ok","location":{"latitude":"50","longitude":"50","label":null}}]}}',
			json_encode($rcs)
		);

		$rcs->configure('rcs', 'TOPefekt', 65);

		Assert::same('TOPefekt',$rcs->sender);
		Assert::same(65, $rcs->timeout);

		$rcs->configure(channel: 'rcs', sender: 'TOPefekt', timeout: 65);

		Assert::same('TOPefekt',$rcs->sender);
		Assert::same(65, $rcs->timeout);
	}

}

(new RcsTest())->run();
