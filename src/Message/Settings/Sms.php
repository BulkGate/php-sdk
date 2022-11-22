<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Channel, Sdk\Message\Component\SmsSender, Sdk\Utils\Strict, Sdk\Message\Component\SimpleText};
use function array_pad;

class Sms implements Settings
{
    use Strict;

    public SimpleText $text;

    public ?string $sender_id;

    public ?string $sender_id_value;

    public ?bool $unicode;


    public function __construct(SimpleText $text, ?string $sender_id = null, ?string $sender_id_value = null, ?bool $unicode = null)
    {
        $this->text = $text;
        $this->sender_id = $sender_id;
        $this->sender_id_value = $sender_id_value;
        $this->unicode = $unicode;
    }


    public function configure(...$parameters): void
    {
        [$channel, $sender_id, $sender_id_value, $unicode] = array_pad($parameters, 4, null);

        if ($channel === Channel::SMS)
        {
            $this->sender_id ??= $sender_id;
            $this->sender_id_value ??= $sender_id_value;
            $this->unicode ??= $unicode;
        }
    }


    /**
     * @return array{text: string, variables: array<string, scalar|null>, sender_id: string, sender_id_value: string, unicode: bool}
     */
    public function jsonSerialize(): array
    {
        return [
            'text' => $this->text->text,
            'variables' => $this->text->variables,
            'sender_id' => $this->sender_id ?? SmsSender::GATE_SYSTEM_NUMBER,
            'sender_id_value' => $this->sender_id_value ?? SmsSender::DEFAULT_SENDER,
            'unicode' => $this->unicode ?? false
        ];
    }
}
