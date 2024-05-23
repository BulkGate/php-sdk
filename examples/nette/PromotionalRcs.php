<?php declare(strict_types=1);

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Sender;
use BulkGate\Sdk\Message\Rcs;
use BulkGate\Sdk\Message\Bulk;
use BulkGate\Sdk\Message\MultiChannel;
use BulkGate\Sdk\Message\Component\Rcs\{Card, Height, Suggestion\CreateCalendarEvent, Suggestion\DialNumber, Suggestion\OpenUrl, Suggestion\Reply, Suggestion\ShareLocation, Suggestion\ViewLocation, Variant, Width};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = \DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);


// @info RCS Text message
$bulk = new Bulk([
	new Rcs(
		phone_number: '420777777777',
		variant: Variant::Text,
		text: 'text',
		suggestions: [
			new ViewLocation(
				text: 'text',
				latitude: 50.0,
				longitude: 50.0
			)
		],
		sender: 'BulkGate',
		timeout: 60
	)
]);


// @info RCS Card message
$bulk[] = new Rcs(
	phone_number: '420777777777',
	variant: Variant::Card,
	title: 'title',
	description: 'description',
	url: 'url',
	force_refresh: false,
	height: Height::Tall,
	suggestions: [
		new ViewLocation(
			text: 'text',
			latitude: 50.0,
			longitude: 50.0
		)
	],
	sender: 'BulkGate',
	timeout: 60
);


// @info RCS File message
$bulk[] = new Rcs(
	phone_number: '420777777777',
	variant: Variant::File,
	url: 'url',
	force_refresh: true,
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
	sender: 'BulkGate',
	timeout: 60
);

// @info RCS Carousel message
$bulk[] = new Rcs(
	phone_number: '420777777777',
	variant: Variant::Carousel,
	cards: [
		new Card(
			title: 'title',
			description: 'description',
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
		new Card(
			title: 'title',
			description: 'description',
			file_url: 'file_url',
			file_refresh: false,
			height: Height::Tall,
			suggestions: [],
		)
	],
	width: Width::Medium,
	sender: 'BulkGate',
	timeout: 60
);


// @info RCS message with all suggestions
$bulk[] = (new MultiChannel('420777777777'))
	->rcs(
		text: 'text',
		suggestions: [
			new ViewLocation(
				text: 'text',
				postback: 'ok',
				latitude: 50.0,
				longitude: 40.0,
				query: 'Karluv most',
				label: 'Karluv most',
			),
			new DialNumber(phone_number: '420777777777', text: 'text', postback: 'ok'),
			new CreateCalendarEvent(
				start: '2000-01-01',
				end: '2000-02-01',
				text: '',
				postback: 'ok',
				title: 'title',
				description: 'description',
				fallback_url: 'url',
				timezone: 'Europe/London'
			),
			new OpenUrl(
				url: 'url',
				text: 'text',
				postback: 'ok',
			),
			new Reply(text: 'text', postback: 'ok'),
			new ShareLocation(text: 'button_text', postback: 'postback')
		]

	);

try {
	//var_dump($bulk->jsonSerialize());

	dump($sender->send($bulk));

	/** @dump
	 * BulkGate\Sdk\Message\Bulk #123
	 * list: array (5)
	 * |  0 => BulkGate\Sdk\Message\Sms #79
	 * |  |  settings: BulkGate\Sdk\Message\Settings\Sms #81
	 * |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #93
	 * |  |  |  |  text: 'test message'
	 * |  |  |  |  variables: array (0)
	 * |  |  |  sender_id: 'gText'
	 * |  |  |  sender_id_value: 'Example'
	 * |  |  |  unicode: true
	 * |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #80
	 * |  |  |  phone_number: '420777777777'
	 * |  |  |  iso: 'cz'
	 * |  |  schedule: null
	 * |  |  status: 'accepted'
	 * |  |  message_id: 'idxxxxxxxxxxxxx-0'
	 * |  |  part_id: array (1)
	 * |  |  |  0 => 'idxxxxxxxxxxxxx-0'
	 * |  |  error: null
	 * |  1 => BulkGate\Sdk\Message\Viber #86
	 * |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #82
	 * |  |  |  phone_number: '420777777777'
	 * |  |  |  iso: null
	 * |  |  settings: BulkGate\Sdk\Message\Settings\Viber #87
	 * |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #83
	 * |  |  |  |  text: 'test message'
	 * |  |  |  |  variables: array (0)
	 * |  |  |  sender: 'BulkGate'
	 * |  |  |  button: null
	 * |  |  |  image: null
	 * |  |  |  timeout: 10800
	 * |  |  schedule: null
	 * |  |  status: 'accepted'
	 * |  |  message_id: 'idxxxxxxxxxxxxx-1'
	 * |  |  part_id: array (1)
	 * |  |  |  0 => 'idxxxxxxxxxxxxx-1'
	 * |  |  error: null
	 * |  2 => BulkGate\Sdk\Message\Viber #118
	 * |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #76
	 * |  |  |  phone_number: '420777777777'
	 * |  |  |  iso: null
	 * |  |  settings: BulkGate\Sdk\Message\Settings\Viber #74
	 * |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #73
	 * |  |  |  |  text: 'test message'
	 * |  |  |  |  variables: array (0)
	 * |  |  |  sender: null
	 * |  |  |  button: null
	 * |  |  |  image: null
	 * |  |  |  timeout: 10800
	 * |  |  schedule: null
	 * |  |  status: 'invalid_sender'
	 * |  |  message_id: null
	 * |  |  part_id: null
	 * |  |  error: 'Invalid sender'
	 * |  3 => BulkGate\Sdk\Message\Sms #72
	 * |  |  settings: BulkGate\Sdk\Message\Settings\Sms #70
	 * |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #69
	 * |  |  |  |  text: 'test message'
	 * |  |  |  |  variables: array (0)
	 * |  |  |  sender_id: 'gText'
	 * |  |  |  sender_id_value: 'Example'
	 * |  |  |  unicode: true
	 * |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #71
	 * |  |  |  phone_number: '420777777777'
	 * |  |  |  iso: 'cz'
	 * |  |  schedule: null
	 * |  |  status: 'accepted'
	 * |  |  message_id: 'idxxxxxxxxxxxxx-3'
	 * |  |  part_id: array (1)
	 * |  |  |  0 => 'idxxxxxxxxxxxxx-3'
	 * |  |  error: null
	 * |  4 => BulkGate\Sdk\Message\MultiChannel #68
	 * |  |  primary_channel: 'viber'
	 * |  |  channels: array (2)
	 * |  |  |  'viber' => BulkGate\Sdk\Message\Settings\Viber #63
	 * |  |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #66
	 * |  |  |  |  |  text: 'Hello <variable>'
	 * |  |  |  |  |  variables: array (1)
	 * |  |  |  |  |  |  'variable' => 'Lukáš'
	 * |  |  |  |  sender: 'BulkGate'
	 * |  |  |  |  button: BulkGate\Sdk\Message\Component\Button #65
	 * |  |  |  |  |  caption: 'Viber'
	 * |  |  |  |  |  url: 'https://www.bulkgate.com/'
	 * |  |  |  |  image: BulkGate\Sdk\Message\Component\Image #64
	 * |  |  |  |  |  url: 'https://opengraph.githubassets.com/3c7f0395b85f435b40c3215187c75df5fdc201b3f34917cb57fdc2019304af69/BulkGate/php-sdk'
	 * |  |  |  |  |  zoom: false
	 * |  |  |  |  timeout: 10800
	 * |  |  |  'sms' => BulkGate\Sdk\Message\Settings\Sms #61
	 * |  |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #62
	 * |  |  |  |  |  text: 'backup text'
	 * |  |  |  |  |  variables: array (0)
	 * |  |  |  |  sender_id: 'gText'
	 * |  |  |  |  sender_id_value: 'Example'
	 * |  |  |  |  unicode: true
	 * |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #67
	 * |  |  |  phone_number: '420777777777'
	 * |  |  |  iso: 'cz'
	 * |  |  schedule: null
	 * |  |  status: 'accepted'
	 * |  |  message_id: 'idxxxxxxxxxxxxx-4'
	 * |  |  part_id: array (1)
	 * |  |  |  0 => 'idxxxxxxxxxxxxx-4'
	 * |  |  error: null
	 */
} catch (Throwable $e) {
	echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
