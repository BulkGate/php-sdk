<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{
    Sdk\ChannelException,
    Sdk\Message\Settings,
    Sdk\Utils\Strict
};

class MultiChannel extends Base
{
    use Strict;

    public ?string $primary_channel = null;

    /** @var array<Settings\Settings> */
    public array $channels = [];


    private const CHANNEL_MAP = [
        Settings\Sms::class => Channel::SMS,
        Settings\Viber::class => Channel::VIBER,
    ];


    public function sms(Component\SimpleText $text, string $sender_id = Component\SmsSender::GATE_SYSTEM_NUMBER, string $sender_id_value = Component\SmsSender::DEFAULT_SENDER, bool $unicode = false): self
    {
        $this->channel(new Settings\Sms($text, $sender_id, $sender_id_value, $unicode));

        return $this;
    }


    public function viber(Component\SimpleText $text, ?string $sender = null, ?Component\Button $button = null, ?Component\Image $image = null, int $timeout = Settings\Viber::DEFAULT_RESEND_TIMEOUT): self
    {
        $this->channel(new Settings\Viber($text, $sender, $button, $image, $timeout));

        return $this;
    }


    /**
     * @param mixed ...$parameters
     */
    public function configure(string $channel, ...$parameters): void
    {
        if (isset($this->channels[$channel]) && $this->channels[$channel] instanceof Settings\Settings)
        {
            $this->channels[$channel]->configure(...$parameters);
        }
    }


    /**
     * @throws ChannelException
     */
    public function setPrimaryChannel(string $channel): self
    {
        if (!isset($this->channels[$channel]))
        {
            throw new ChannelException("Channel '$channel' is not defined.");
        }

        $this->primary_channel = $channel;

        return $this;
    }


    public function channel(Settings\Settings $settings): self
    {
        $class = get_class($settings); /** @php8 $settings::class */

        $channel = self::CHANNEL_MAP[$class] ?? null;

        if ($channel !== null)
        {
            $this->primary_channel ??= $channel;

            $this->channels[$channel] = $settings;
        }

        return $this;
    }


    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'primary_channel' => $this->primary_channel,
            'phone_number' => (string) $this->phone_number,
            'country' => $this->phone_number->iso,
            'schedule' => $this->schedule,
            'channels' => $this->channels
        ];
    }


    public function getChannels(): array
    {
        return array_keys($this->channels);
    }
}
