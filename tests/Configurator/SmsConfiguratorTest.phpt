<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Configurator\PrefixMap;
use BulkGate\Sdk\Configurator\SmsConfigurator;
use BulkGate\Sdk\Message\Component\SimpleText;
use BulkGate\Sdk\Message\MultiChannel;
use BulkGate\Sdk\Message\Sms;

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class SmsConfiguratorTest extends TestCase
{
    private ?Sms $sms = null;

    public function setUp()
    {
        $this->sms = new Sms('420608777777', 'test');
    }


    public function testConstruct(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->configure($this->sms);

        Assert::same(['gSystem', ''], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value]);
    }


    public function testSpecificConstruct(): void
    {
        $configurator = new SmsConfigurator('gText', 'BulkGate', true);

        $configurator->configure($this->sms);

        Assert::same(['gText', 'BulkGate', true], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testSystemNumber(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->systemNumber();

        $configurator->configure($this->sms);

        Assert::same(['gSystem', '', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testShortCode(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->shortCode();

        $configurator->configure($this->sms);

        Assert::same(['gShort', '', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testTextSender(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->textSender('TOPefekt');

        $configurator->configure($this->sms);

        Assert::same(['gText', 'TOPefekt', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testOwnNumber(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->numericSender('420777777777');

        $configurator->configure($this->sms);

        Assert::same(['gOwn', '420777777777', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testMobileConnect(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->mobileConnect('XXXXXX');

        $configurator->configure($this->sms);

        Assert::same(['gMobile', 'XXXXXX', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testPortalProfile(): void
    {
        $configurator = new SmsConfigurator();

        $configurator->portalProfile(150);

        $configurator->configure($this->sms);

        Assert::same(['gProfile', '150', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
    }


    public function testMultiChannel(): void
    {
        $message = new MultiChannel('420777777777');
        $message->viber(new SimpleText('test2'))->sms(new SimpleText('test2'));

        $configurator = new SmsConfigurator('gText', 'BulkGate');

        $configurator->unicode();

        $configurator->configure($message);

        Assert::same(['gText', 'BulkGate', true], [$message->channels['sms']->sender_id, $message->channels['sms']->sender_id_value, $message->channels['sms']->unicode]);
    }


    public function testChannel(): void
    {
        $configurator = new SmsConfigurator();

        Assert::same('sms', $configurator->getChannel());
    }
}

(new SmsConfiguratorTest())->run();
