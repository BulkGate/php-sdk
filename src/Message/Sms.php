<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Component\SimpleText, Sdk\Utils\Strict};

class Sms extends Base
{
    use Strict;

    public Settings\Sms $settings;


    public function __construct($phone_number, ?SimpleText $text = null)
    {
        parent::__construct($phone_number);
        $this->settings = new Settings\Sms($text ?? new SimpleText());
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
            'primary_channel' => Channel::SMS,
            'phone_number' => (string) $this->phone_number,
            'country' => $this->phone_number->iso,
            'channels' => [
                Channel::SMS => $this->settings
            ]
        ];
    }


    public function getChannels(): array
    {
        return [Channel::SMS];
    }
}
