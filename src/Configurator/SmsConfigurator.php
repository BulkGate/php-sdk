<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\{Channel, Component\SmsSender, Base};
use function mb_substr;

class SmsConfigurator implements Configurator
{
    protected string $sender_id;

    protected string $sender_id_value;

    protected bool $unicode;


    public function __construct(string $sender_id = SmsSender::GATE_SYSTEM_NUMBER, string $sender_value = SmsSender::DEFAULT_SENDER, bool $unicode = false)
    {
        $this->sender_id = $sender_id;
        $this->sender_id_value = $sender_value;
        $this->unicode = $unicode;
    }


    public function unicode(bool $enabled = true): void
    {
        $this->unicode = $enabled;
    }


    public function systemNumber(): void
    {
        $this->sender_id = SmsSender::GATE_SYSTEM_NUMBER;
        $this->sender_id_value = SmsSender::DEFAULT_SENDER;
    }


    public function shortCode(): void
    {
        $this->sender_id = SmsSender::GATE_SHORT_CODE;
        $this->sender_id_value = SmsSender::DEFAULT_SENDER;
    }


    public function textSender(string $value): void
    {
        $this->sender_id = SmsSender::GATE_TEXT_SENDER;
        $this->sender_id_value = mb_substr($value, 0, 11);
    }


    public function numericSender(string $value): void
    {
        $this->sender_id = SmsSender::GATE_OWN_NUMBER;
        $this->sender_id_value = $value;
    }


    public function mobileConnect(string $key): void
    {
        $this->sender_id = SmsSender::GATE_MOBILE_CONNECT;
        $this->sender_id_value = $key;
    }


    /**
     * @param int<1, max> $id
     */
    public function portalProfile(int $id): void
    {
        $this->sender_id = SmsSender::GATE_PORTAL_PROFILE;
        $this->sender_id_value = "$id";
    }


    public function configure(Base $message): void
    {
        $message->configure(Channel::SMS, $this->sender_id, $this->sender_id_value, $this->unicode);
    }


    public function getChannel(): string
    {
        return Channel::SMS;
    }
}
