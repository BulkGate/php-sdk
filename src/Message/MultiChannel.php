<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\ChannelException, Sdk\Message\Settings, Sdk\Utils\Strict};
use function get_class, array_keys;

class MultiChannel extends Base
{
    use Strict;

    public ?string $primary_channel = null;

    /**
     * @var array<string, Settings\Settings>
     */
    public array $channels = [];


    private const ChannelMap = [
        Settings\Sms::class => Channel::SMS,
        Settings\Viber::class => Channel::VIBER,
    ];


    public function sms(Component\SimpleText $text, ?string $sender_id = null, ?string $sender_id_value = null, ?bool $unicode = null): self
    {
        $this->channel(new Settings\Sms($text, $sender_id, $sender_id_value, $unicode));

        return $this;
    }


    /**
     * @param int<60, max>|null $timeout
     */
    public function viber(Component\SimpleText $text, ?string $sender = null, ?Component\Button $button = null, ?Component\Image $image = null, ?int $timeout = null): self
    {
        $this->channel(new Settings\Viber($text, $sender, $button, $image, $timeout));

        return $this;
    }


    /**
     * @param mixed ...$parameters
     */
    public function configure(...$parameters): void
    {
        $channel = $parameters[0] ?? null;

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

        $channel = self::ChannelMap[$class] ?? null;

        if ($channel !== null)
        {
            $this->primary_channel ??= $channel;

            $this->channels[$channel] = $settings;
        }

        return $this;
    }


    /**
     * @return array{primary_channel: string, phone_number: string, country: string|null, channels: array<string, Settings\Settings>}
     */
    public function jsonSerialize(): array
    {
        return [
            'primary_channel' => $this->primary_channel ?? Channel::SMS,
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
