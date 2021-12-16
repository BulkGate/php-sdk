<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Component\SmsSender, Sdk\Utils\Strict, Sdk\Message\Component\SimpleText};
use function array_pad;

class Sms implements Settings
{
    use Strict;

    public SimpleText $text;

    public string $sender_id;

    public string $sender_id_value;

    public bool $unicode;


    public function __construct(SimpleText $text, string $sender_id = SmsSender::GATE_SYSTEM_NUMBER, string $sender_id_value = SmsSender::DEFAULT_SENDER, bool $unicode = false)
    {
        $this->text = $text;
        $this->sender_id = $sender_id;
        $this->sender_id_value = $sender_id_value;
        $this->unicode = $unicode;
    }


    public function configure(...$parameters): void
    {
        [$sender_id, $sender_id_value, $unicode] = array_pad($parameters, 3, null);

        $this->sender_id = $sender_id ?? SmsSender::GATE_SYSTEM_NUMBER;
        $this->sender_id_value = $sender_id_value ?? SmsSender::DEFAULT_SENDER;
        $this->unicode = $unicode ?? false;
    }


    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'text' => $this->text->text,
            'variables' => $this->text->variables,
            'sender_id' => $this->sender_id,
            'sender_id_value' => $this->sender_id_value,
            'unicode' => $this->unicode
        ];
    }
}
