<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\{Card, Suggestion\OpenUrl, Suggestion\Reply};

/**
 * @testCase
 */
class CardTest extends TestCase
{
	public function testCard(): void
	{
		$card = new Card(
			title: 'title',
			description: 'description',

			file_url: 'image_url', file_refresh: false,
			height: 'tall',
			suggestions: [new OpenUrl('https://www.bulkgate.com/', 'open bulkgate')]);

		$card[] = new Reply('reply1', 'postback1');
		$card[] = new Reply('reply2', 'postback2');
		//$card[] = new Card('reply2', 'postback2');

		Assert::same([
			'title' => 'title',
			'description' => 'description',
			'orientation' => null,
			'alignment' => null,
			'suggestions' => [
				[
					'type' => 'open_url',
					'text' => 'open bulkgate',
					'postback' => 'ok',
					'url' => 'https://www.bulkgate.com/',
				],
				['type' => 'reply', 'text' => 'reply1', 'postback' => 'postback1'],
				['type' => 'reply', 'text' => 'reply2', 'postback' => 'postback2'],
			],
			'media' => ['height' => 'TALL', 'url' => 'image_url', 'forceRefresh' => false],
		], $card->serialize());
	}


	public function testDefaultImage(): void
	{
		$card = new Card();

		$card[] = new Reply('reply1', 'postback1');

		Assert::same([
			'title' => '',
			'description' => '',
			'orientation' => null,
			'alignment' => null,
			'suggestions' => [['type' => 'reply', 'text' => 'reply1', 'postback' => 'postback1']],
			'media' => [
				'height' => 'TALL',
				'url' => 'https://portal.bulkgate.com/images/choice.png',
				'forceRefresh' => false,
			],
		], $card->serialize());

		Assert::same([
			'title' => '',
			'description' => '',
			'orientation' => null,
			'alignment' => null,
			'suggestions' => [['type' => 'reply', 'text' => 'reply1', 'postback' => 'postback1']],
			'media' => [
				'height' => 'MEDIUM',
				'url' => 'https://portal.bulkgate.com/images/choice.png',
				'forceRefresh' => false,
			],
		], $card->serialize(true));

		$card[] = $x = new Reply('reply2', 'postback1');

		Assert::same([
			'title' => '',
			'description' => '',
			'orientation' => null,
			'alignment' => null,
			'suggestions' => [
				['type' => 'reply', 'text' => 'reply1', 'postback' => 'postback1'],
				['type' => 'reply', 'text' => 'reply2', 'postback' => 'postback1'],
			],
			'media' => [
				'height' => 'SHORT',
				'url' => 'https://portal.bulkgate.com/images/choice.png',
				'forceRefresh' => false,
			],
		], $card->serialize(true));

		Assert::true(isset($card[0]));
		Assert::false(isset($card[20]));

		unset($card[0]);

		Assert::false(isset($card[0]));

		Assert::same($x, $card[1]);
	}
}

(new CardTest())->run();
