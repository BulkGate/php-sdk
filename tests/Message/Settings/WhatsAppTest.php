<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\WhatsApp\Components\BodyText, Sdk\Message\Component\WhatsApp\Components\BodyType,
	Sdk\Message\Component\WhatsApp\Components\ButtonQuickReplyPayload, Sdk\Message\Component\WhatsApp\Components\FileType, Sdk\Message\Component\WhatsApp\Components\HeaderMedia, Sdk\Message\Component\WhatsApp\Components\HeaderType, Sdk\Message\Settings\RcsText, Sdk\Message\Settings\WhatsAppFile,
	Sdk\Message\Settings\WhatsAppLocation, Sdk\Message\Settings\WhatsAppMessage, Sdk\Message\Settings\WhatsAppOtp, Sdk\Message\Settings\WhatsAppTemplate};
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class WhatsAppTest extends TestCase
{
	public function testMessage(): void
	{
		$whatsapp = new WhatsAppMessage(sender: $sender = 'BulkGate', text: $text = 'text', timeout: $timeout = 65, preview_url: false);

		Assert::same($text, $whatsapp->text);
		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::false($whatsapp->preview_url);

		Assert::same('{"sender":"BulkGate","expiration":65,"message":{"text":"text","preview_url":false}}',
			json_encode($whatsapp)
		);

		// Restrict rewrite
		$whatsapp->configure('whatsapp', 'TOPefekt', 65, true);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::false($whatsapp->preview_url);

		$whatsapp->configure(channel: 'whatsapp', sender: 'TOPefekt', timeout: 65, preview_url: true);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::false($whatsapp->preview_url);
	}


	public function testLocation(): void
	{
		$whatsapp = new WhatsAppLocation(
			latitude: $latitude = 50.0,
			longitude: $longitude = 40.1,
			name: $name = 'Karluv most',
			address: 'Karluv most',
			sender: $sender = 'BulkGate',
			timeout: $timeout = 65
		);


		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($latitude, $whatsapp->latitude);
		Assert::same($longitude, $whatsapp->longitude);
		Assert::same($name, $whatsapp->name);

		Assert::same('{"sender":"BulkGate","expiration":65,"location":{"latitude":50,"longitude":40.1,"name":"Karluv most","address":"Karluv most"}}',
			json_encode($whatsapp)
		);

		// Restrict rewrite
		$whatsapp->configure('whatsapp', 'TOPefekt', 65, true);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);

		$whatsapp->configure(channel: 'whatsapp', sender: 'TOPefekt', timeout: 65);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
	}


	public function testOtp(): void
	{
		$whatsapp = new WhatsAppOtp(
			sender: $sender = 'BulkGate',
			template: $template = 'verification_code',
			code: $code = '',
			language: $language = 'en',
			timeout: $timeout = 65
		);


		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($template, $whatsapp->template);
		Assert::same($code, $whatsapp->code);
		Assert::same($language, $whatsapp->language);

		Assert::same('{"sender":"BulkGate","expiration":65,"otp":{"template":"verification_code","code":"","language":"en"}}',
			json_encode($whatsapp)
		);

		// Restrict rewrite
		$whatsapp->configure('whatsapp', 'TOPefekt', 65);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);

		$whatsapp->configure(channel: 'whatsapp', sender: 'TOPefekt', timeout: 65);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
	}


	public function testTemplate(): void
	{
		$whatsapp = new WhatsAppTemplate(
			header: $header = new HeaderMedia(type: HeaderType::Image, url: 'url', caption: 'caption'),
			body: $body = new BodyText(type: BodyType::Text, text: 'text'),
			buttons: $buttons = [0 => new ButtonQuickReplyPayload(index: 1, payload: 'payload')],
			template: $template = 'verification_code',
			language: $language = 'en',
			sender: $sender = 'BulkGate',
			timeout: $timeout = 65
		);


		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($template, $whatsapp->template);
		Assert::same($header, $whatsapp->header);
		Assert::same($body, $whatsapp->body);
		Assert::same($buttons, $whatsapp->buttons);
		Assert::same($language, $whatsapp->language);

		Assert::same('{"sender":"BulkGate","expiration":65,"template":{"template":"verification_code","language":"en","header":{"type":"image","url":"url","caption":"caption"},"body":{"type":"text","text":"text"},"buttons":[{"type":"payload","index":1,"payload":"payload"}]}}',
			json_encode($whatsapp)
		);

		// Restrict rewrite
		$whatsapp->configure('whatsapp', 'TOPefekt', 65, 'cz');

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($language, $whatsapp->language);

		$whatsapp->configure(channel: 'whatsapp', sender: 'TOPefekt', timeout: 65, language: 'cz');

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($language, $whatsapp->language);
	}


	public function testFile(): void
	{
		$whatsapp = new WhatsAppFile(
			sender: $sender = 'BulkGate',
			type: $type = FileType::Document,
			url: $url = 'url',
			caption: $caption = 'caption',
			timeout: $timeout = 65
		);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
		Assert::same($type, $whatsapp->type);
		Assert::same($url, $whatsapp->url);
		Assert::same($caption, $whatsapp->caption);

		Assert::same('{"sender":"BulkGate","expiration":65,"file":{"type":"DOCUMENT","url":"url","caption":"caption"}}',
			json_encode($whatsapp)
		);

		// Restrict rewrite
		$whatsapp->configure('whatsapp', 'TOPefekt', 'cz', 65);

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);

		$whatsapp->configure(channel: 'whatsapp', sender: 'TOPefekt', timeout: 65, language: 'cz');

		Assert::same($sender, $whatsapp->sender);
		Assert::same($timeout, $whatsapp->timeout);
	}
}

(new WhatsAppTest())->run();
