<?php declare(strict_types=1);

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Sender;
use BulkGate\Sdk\Message\{Bulk, Component\SimpleText, Component\WhatsApp\Components\BodyType, Component\WhatsApp\Components\ButtonQuickReplyPayload, Component\WhatsApp\Components\ButtonUrlParameter, Component\WhatsApp\Components\FileType, Component\WhatsApp\Components\HeaderMedia,
	Component\WhatsApp\Components\HeaderType, Component\WhatsApp\Variant, MultiChannel, WhatsApp
};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = \DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);

/** @info WhatsApp Text message */
$bulk = new Bulk([
	new WhatsApp(
		phone_number: '+420777777777',
		variant: Variant::Text,
		text: 'text',
		preview_url: true,
		sender: 'BulkGate',
		timeout: 60,
	)
]);

/** @info WhatsApp File message */
$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::File,
	type: FileType::Image,
	url: 'url',
	caption: 'caption',
	sender: 'BulkGate',
	timeout: 60,
);


/** @info WhatsApp Otp message */
$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Otp,
	template: 'verification code:',
	language: 'en',
	code: '0451',
	sender: 'BulkGate',
	timeout: 60,
);


/** @info WhatsApp Location message */
$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Location,
	latitude: 50.0,
	longitude: 40.0,
	name: 'Karluv most',
	address: 'Karluv most',
	sender: 'BulkGate',
	timeout: 60,
);


/** @info WhatsApp Template message (Header image, Body Text, Buttons) */
$header_type = HeaderType::Image;
$header = $header_type->createSettings(
	type: HeaderType::Image,
	url: 'url',
	caption: 'caption'
);

$body_type = BodyType::Text;
$body = $body_type->createSettings(
	type: BodyType::Text,
	text: 'text'
);

$buttons = [
	new ButtonQuickReplyPayload(index: 1, payload: 'test_payload'),
	new ButtonUrlParameter(index: 1, text: 'text')
];

$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Template,
	template: 'template text',
	language: 'en',
	header: $header,
	body: $body,
	buttons: $buttons,
	sender: 'BulkGate',
	timeout: 60,
);


/** @info WhatsApp Template message (Header Video, Body Price) */
$header_type = HeaderType::Video;
$header = $header_type->createSettings(
	type: HeaderType::Video,
	url: 'url',
	caption: 'caption'
);

$body_type = BodyType::Price;
$body = $body_type->createSettings(
	type: BodyType::Price,
	amount: 1,
	currency: 'euro'
);

$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Template,
	template: 'template text',
	language: 'en',
	header: $header,
	body: $body,
	sender: 'BulkGate',
	timeout: 60,
);


/** @info WhatsApp Template message (Header Location, Body Currency) */
$header_type = HeaderType::Location;
$header = $header_type->createSettings(
	type: HeaderType::Location,
	latitude: 50.0,
	longitude: 40.0,
	name: 'Karluv most',
	address: 'Karluv most'
);

$body_type = BodyType::Currency;
$body = $body_type->createSettings(
	type: BodyType::Currency,
	amount: 1,
	currency: 'euro'
);

$bulk[] = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Template,
	template: 'template text',
	language: 'en',
	header: $header,
	body: $body,
	sender: 'BulkGate',
	timeout: 60,
);


/** @info Primary Viber message with SMS backup */
$bulk[] = (new MultiChannel('420777777777'))
	->whatsapp(
		variant: Variant::Template,
		template: 'template text',
		language: 'en',
		header: $header,
		body: $body,
		sender: 'BulkGate',
		timeout: 60,
	)->sms(
		text: new SimpleText('backup text'),
		sender_id: 'gText',
		sender_id_value: 'BulkGate'
	);


try {
	dump($sender->send($bulk));


} catch (Throwable $e) {
	echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

