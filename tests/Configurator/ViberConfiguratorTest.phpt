<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Configurator\SmsConfigurator;
use BulkGate\Sdk\Configurator\ViberConfigurator;
use BulkGate\Sdk\Message\Viber;

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class ViberConfiguratorTest extends TestCase
{
    private ?Viber $viber = null;

    public function setUp()
    {
        $this->viber = new Viber('420608777777', 'test');
    }


    public function testConstruct(): void
    {
        $configurator = new ViberConfigurator('BulkGate');

        $configurator->configure($this->viber);

        Assert::same(['BulkGate', null, null, 10800], [$this->viber->settings->sender, $this->viber->settings->button, $this->viber->settings->image, $this->viber->settings->timeout]);
    }


    public function testSimple(): void
    {
        $configurator = new ViberConfigurator('TOPefekt');

        $configurator->image('url', true);

        $configurator->button('buy it', 'url_button');

        $configurator->expiration(500);

        $configurator->configure($this->viber);

        Assert::same([
            'TOPefekt',
            ['caption' => 'buy it', 'url' => 'url_button'],
            ['url' => 'url', 'zoom' => true],
            10800,
        ], [$this->viber->settings->sender, (array) $this->viber->settings->button, (array) $this->viber->settings->image, $this->viber->settings->timeout]);
    }


    public function testChannel(): void
    {
        $configurator = new ViberConfigurator('Sender');

        Assert::same('viber', $configurator->getChannel());
    }
}

(new ViberConfiguratorTest())->run();
