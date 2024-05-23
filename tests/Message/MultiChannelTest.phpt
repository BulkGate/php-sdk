<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\ChannelException, Sdk\Message\Component\Rcs\Variant as RcsVariant, Sdk\Message\Component\Viber\Variant, Sdk\Message\Component\WhatsApp\Variant as WhatsAppVariant, Sdk\Message\MultiChannel, Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\PhoneNumber,
	Sdk\Message\Component\SimpleText};
use function json_decode, json_encode;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class MultiChannelTest extends TestCase
{
    public function testSimple(): void
    {
        $message = new MultiChannel(new PhoneNumber('420608777777', 'cz'));

        Assert::null($message->primary_channel);

        $message
	        ->whatsapp(variant: WhatsAppVariant::Text, text: 'text', sender: 'BulkGate')
	        ->rcs(variant: RcsVariant::Text, text: 'test', sender: 'BulkGate')
            ->viber(text: new SimpleText(text:'text_viber', variables: []), sender: 'BulkGate', button: new Button('caption', 'url'), image: new Image('image_url', true), timeout: 3_600, variant: Variant::Card)
            ->sms(new SimpleText('test_sms', []), 'gText', 'BulkGate', true);

        Assert::same('whatsapp', $message->primary_channel);

        $message->schedule = 150;

        Assert::same([
	        'primary_channel' => 'whatsapp',
	        'phone_number' => '420608777777',
	        'country' => 'cz',
	        'schedule' => 150,
	        'channels' => [
		        'whatsapp' => [
			        'sender' => 'BulkGate',
			        'expiration' => 180,
			        'message' => ['text' => 'text', 'preview_url' => true],
		        ],
		        'rcs' => [
			        'sender' => 'BulkGate',
			        'expiration' => 60,
			        'message' => ['text' => 'test', 'suggestions' => []],
		        ],
		        'viber' => [
			        'text' => 'text_viber',
			        'variables' => [],
			        'sender' => 'BulkGate',
			        'button_caption' => 'caption',
			        'button_url' => 'url',
			        'image' => 'image_url',
			        'image_zoom' => true,
			        'expiration' => 3600,
		        ],
		        'sms' => [
			        'text' => 'test_sms',
			        'variables' => [],
			        'sender_id' => 'gText',
			        'sender_id_value' => 'BulkGate',
			        'unicode' => true,
		        ],
	        ],
        ], json_decode(json_encode($message), true));

        Assert::same(['whatsapp', 'rcs', 'viber', 'sms'], $message->getChannels());

        $message->setPrimaryChannel('sms');

        Assert::same('sms', $message->primary_channel);

        Assert::exception(fn () => $message->setPrimaryChannel('xxxx'), ChannelException::class, 'Channel \'xxxx\' is not defined.');
    }


    public function testConfigure(): void
    {
        $message = new MultiChannel(new PhoneNumber('420608777777', 'cz'));

        Assert::null($message->primary_channel);

        $message
	        ->whatsapp(text: 'text', sender: 'BulkGate')
	        ->rcs(text: 'text', sender: 'BulkGate')
            ->viber(text: new SimpleText('text_viber', []), sender: 'BulkGate')
            ->sms(new SimpleText('test_sms', []), null, null, true);

        $message->configure('sms', 'gShort', '');
        $message->configure('viber', 'TOPefekt', 65);
		$message->configure('rcs', 'TOPefekt', 65);
		$message->configure('whatsapp', 'TOPefekt', 65, false);

        Assert::same([
	        'primary_channel' => 'whatsapp',
	        'phone_number' => '420608777777',
	        'country' => 'cz',
	        'schedule' => null,
	        'channels' => [
		        'whatsapp' => [
			        'sender' => 'BulkGate',
			        'expiration' => 65,
			        'message' => ['text' => 'text', 'preview_url' => true],
		        ],
		        'rcs' => [
			        'sender' => 'BulkGate',
			        'expiration' => 65,
			        'message' => ['text' => 'text', 'suggestions' => []],
		        ],
		        'viber' => [
			        'text' => 'text_viber',
			        'sender' => 'BulkGate',
			        'expiration' => 65,
			        'variables' => [],
		        ],
		        'sms' => [
			        'text' => 'test_sms',
			        'variables' => [],
			        'sender_id' => 'gShort',
			        'sender_id_value' => '',
			        'unicode' => true,
		        ],
	        ],
        ], json_decode(json_encode($message), true));
    }
}

(new MultiChannelTest())->run();
