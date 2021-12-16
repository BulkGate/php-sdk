<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Configurator\PrefixMap;
use BulkGate\Sdk\Configurator\SmsConfigurator;
use BulkGate\Sdk\Configurator\SmsCountryConfigurator;
use BulkGate\Sdk\Message\Component\SimpleText;
use BulkGate\Sdk\Message\MultiChannel;
use BulkGate\Sdk\Message\Sms;

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class SmsCountryConfiguratorTest extends TestCase
{
    private ?Sms $sms = null;

    public function setUp()
    {
        $this->sms = new Sms('420608777777', 'test');
    }


    public function testConstruct(): void
    {
        $configurator = new SmsCountryConfigurator();

        $configurator->configure($this->sms);

        Assert::same(['gGate1', ''], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value]);
    }


    public function testAdd(): void
    {
        $configurator = new SmsCountryConfigurator();

        $configurator
            ->addCountry('cz', 'gGate2', 'BulkGate')
            ->addCountry('sk', 'gGate4', 'TOPefekt');

        $configurator->configure($this->sms);

        Assert::same(['gGate2', 'BulkGate'], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value]);

        $sk_message = new Sms('421777777777', 'test');

        $configurator->configure($sk_message);

        Assert::same(['gGate4', 'TOPefekt'], [$sk_message->settings->sender_id, $sk_message->settings->sender_id_value]);

        $configurator->removeCountry('sk');

        $configurator->configure($sk_message);

        Assert::same(['gGate1', ''], [$sk_message->settings->sender_id, $sk_message->settings->sender_id_value]);
    }


    public function testChannel(): void
    {
        $configurator = new SmsCountryConfigurator();

        Assert::same('sms', $configurator->getChannel());
    }
}

(new SmsCountryConfiguratorTest())->run();
