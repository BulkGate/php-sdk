<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, TypeError};

abstract class Base implements Message, Send
{
    use Strict;

    public Component\PhoneNumber $phone_number;

    public ?int $schedule = null;

    public string $status = 'preparation';

    public ?string $message_id = null;

    /**
     * @var array<int, string>|null
     */
    public ?array $part_id = null;

    public ?string $error = null;


    /**
     * @param Component\PhoneNumber|string|null $phone_number
     * @throws TypeError
     */
    public function __construct(/* @php8 Component\PhoneNumber|string */ $phone_number)
    {
        $this->phone_number = Helpers::createNumber($phone_number);
    }


    /**
     * @param mixed ...$parameters
     */
    abstract public function configure(...$parameters): void;


    /**
     * @param array<int, string>|null $part_id
     */
    public function updateStatus(string $status, ?string $message_id, ?array $part_id, ?string $error = null): void
    {
        $this->status = $status;
        $this->message_id = $message_id;
        $this->part_id = $part_id;
        $this->error = $error;
    }


    public function __toString(): string
    {
        return "$this->phone_number";
    }
}
