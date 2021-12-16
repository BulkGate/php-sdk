<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\ChannelException;
use BulkGate\Sdk\Message\MultiChannel;
use BulkGate\Sdk\Message\Component\{Button, Image, PhoneNumber, SimpleText};
use function json_decode, json_encode;

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class MultiChannelTest extends TestCase
{
    public function testSimple(): void
    {
        $message = new MultiChannel(new PhoneNumber('420608777777', 'cz'));

        Assert::null($message->primary_channel);

        $message
            ->viber(new SimpleText('text_viber', []), 'BulkGate', new Button('caption', 'url'), new Image('image_url', true), 3_600)
            ->sms(new SimpleText('test_sms', []), 'gText', 'BulkGate', true);

        Assert::same('viber', $message->primary_channel);

        $message->schedule = 150;

        Assert::same([
            'primary_channel' => 'viber',
            'phone_number' => '420608777777',
            'country' => 'cz',
            'schedule' => 150,
            'channels' => [
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

        Assert::same(['viber', 'sms'], $message->getChannels());

        $message->setPrimaryChannel('sms');

        Assert::same('sms', $message->primary_channel);

        Assert::exception(fn () => $message->setPrimaryChannel('xxxx'), ChannelException::class, 'Channel \'xxxx\' is not defined.');

        $message->configure('sms', 'gShort', '');
        $message->configure('viber', 'TOPefekt');

        Assert::same([
            'primary_channel' => 'sms',
            'phone_number' => '420608777777',
            'country' => 'cz',
            'schedule' => 150,
            'channels' => [
                'viber' => [
                    'text' => 'text_viber',
                    'variables' => [],
                    'sender' => 'TOPefekt',
                    'button_caption' => 'OK',
                    'button_url' => '#',
                    'image' => null,
                    'image_zoom' => false,
                    'expiration' => 10800,
                ],
                'sms' => [
                    'text' => 'test_sms',
                    'variables' => [],
                    'sender_id' => 'gShort',
                    'sender_id_value' => '',
                    'unicode' => false,
                ],
            ],
        ], json_decode(json_encode($message), true));
    }
}

(new MultiChannelTest())->run();
