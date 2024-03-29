<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Settings\Viber, Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\SimpleText};
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class ViberTest extends TestCase
{
    public function testSimple(): void
    {
        $viber = new Viber($text = new SimpleText('test <a>', ['a' => 5]), 'BulkGateViber', $button = new Button('test', 'url'), $image = new Image('url_image'));

        Assert::same($text, $viber->text);
        Assert::same($button, $viber->button);
        Assert::same($image, $viber->image);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender":"BulkGateViber","button_caption":"test","button_url":"url","image":"url_image","image_zoom":false,"expiration":10800}', json_encode($viber));
    }


    public function testConfigure(): void
    {
        $viber = new Viber($text = new SimpleText('test <a>', ['a' => 5]));

        Assert::same($text, $viber->text);

        $viber->configure('viber', 'TOPefekt', new Button('ok', 'temp'));
        $viber->configure('viber', 'TOPefekt1', new Button('ok1', 'temp1'), new Image('url', true), 5000);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender":"TOPefekt","button_caption":"ok","button_url":"temp","image":"url","image_zoom":true,"expiration":5000}', json_encode($viber));
    }


    public function testConstruct(): void
    {
        $viber = new Viber(new SimpleText('test <a>', ['a' => 5]));

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender":null,"button_caption":"OK","button_url":"#","image":null,"image_zoom":false,"expiration":10800}', json_encode($viber));
    }
}

(new ViberTest())->run();
