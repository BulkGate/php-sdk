<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{
    Sdk\Message\Component\Button,
    Sdk\Message\Component\Image,
    Sdk\Message\Component\SimpleText,
    Sdk\TypeError,
    Sdk\Utils\Strict
};

class Viber extends Base
{
    use Strict;

    public Component\PhoneNumber $phone_number;

    public Settings\Viber $settings;


    /**
     * @param Component\PhoneNumber|string $phone_number
     * @throws TypeError
     */
    public function __construct($phone_number, ?SimpleText $text = null, ?string $sender = null, ?Button $button = null, ?Image $image = null, int $timeout = Settings\Viber::DEFAULT_RESEND_TIMEOUT)
    {
        parent::__construct($phone_number);
        $this->settings = new Settings\Viber($text ?? new SimpleText(), $sender, $button, $image, $timeout);
    }


    /**
     * @param array<string|int|float> $variables
     */
    public function text(string $text, array $variables = []): self
    {
        $this->settings->text->text($text, $variables);

        return $this;
    }


    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'primary_channel' => Channel::VIBER,
            'phone_number' => (string) $this->phone_number,
            'country' => $this->phone_number->iso,
            'channels' => [
                Channel::VIBER => $this->settings
            ]
        ];
    }


    public function getChannels(): array
    {
        return [Channel::VIBER];
    }
}
