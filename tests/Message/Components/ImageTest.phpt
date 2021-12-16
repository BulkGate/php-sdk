<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Image;

require __DIR__ . '/../../bootstrap.php';

/** @testCase */
class ImageTest extends TestCase
{
    public function testSimple(): void
    {
        $button = new Image('url1', true);

        Assert::same('url1', $button->url);
        Assert::true($button->zoom);

        $button->url = 'url2';
        $button->zoom = false;

        Assert::same('url2', $button->url);
        Assert::false($button->zoom);
    }


    public function testConstruct(): void
    {
        $button = new Image('url1');

        Assert::same('url1', $button->url);
        Assert::false($button->zoom);
    }
}

(new ImageTest())->run();
