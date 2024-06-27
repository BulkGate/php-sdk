<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\SimpleText, Sdk\Message\Settings\ViberCard, Sdk\Message\Settings\ViberText};
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class ViberTest extends TestCase
{
    public function testSimple(): void
    {
        $viber = new ViberCard(text: $text = new SimpleText('test <a>', ['a' => 5]), timeout: 10800, sender:'BulkGateViber', button: $button = new Button('test', 'url'), image: $image = new Image('url_image'));

        Assert::same($text, $viber->text);
        Assert::same($button, $viber->button);
        Assert::same($image, $viber->image);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender":"BulkGateViber","button_caption":"test","button_url":"url","image":"url_image","image_zoom":false,"expiration":10800}', json_encode($viber));
    }


    public function testConfigure(): void
    {
        $viber = new ViberCard($text = new SimpleText('test <a>', ['a' => 5]));

        Assert::same($text, $viber->text);

        $viber->configure('viber', 'TOPefekt', 3600);
        $viber->configure('viber', 'TOPefekt1', 5000);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender":"TOPefekt","button_caption":"OK","button_url":"#","image":null,"image_zoom":false,"expiration":3600}', json_encode($viber));

	    $viber->configure(channel: 'viber', sender: 'TOPefekt1', timeout: 5000);

	    Assert::same('{"text":"test <a>","variables":{"a":5},"sender":"TOPefekt","button_caption":"OK","button_url":"#","image":null,"image_zoom":false,"expiration":3600}', json_encode($viber));

    }


    public function testConstruct(): void
    {
        $viber = new ViberText(new SimpleText('test <a>', ['a' => 5]));

	    $viber->configure(channel: 'viber', sender: 'TOPefekt1', timeout: 5000);

        Assert::same('{"text":"test <a>","sender":"TOPefekt1","expiration":5000,"variables":{"a":5}}', json_encode($viber));
    }
}

(new ViberTest())->run();
