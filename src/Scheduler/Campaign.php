<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use DateTime;
use BulkGate\Sdk\{InvalidStateException, Message\Base, Utils\Strict};
use function mb_strtolower, max, in_array, implode;

class Campaign implements Scheduler
{
    use Strict;

    private DateTime $datetime;

    private DateTime $datetime_working;

    /**
     * @var int<0, max>
     */
    private int $per_messages = 0;

    private string $per_unit = 'day';

    /**
     * @var positive-int
     */
    private int $per_value = 1;

    /**
     * @var int<0, max>
     */
    private int $counter = 0;


    public function __construct(DateTime $datetime)
    {
        $this->datetime($datetime);
    }


    public function datetime(DateTime $datetime): self
    {
        $this->datetime = $datetime;
        $this->datetime_working = clone $datetime;

        return $this;
    }


    /**
     * @param int<0, max> $messages
     * @param positive-int $per_value
     * @throws InvalidStateException
     */
    public function restriction(int $messages, int $per_value = 1, string $per_unit = 'day'): self
    {
        $per_unit = mb_strtolower($per_unit);

        if (!in_array($per_unit, $units = ['day', 'days', 'hour', 'hours', 'minute', 'minutes'], true))
        {
            throw new InvalidStateException("Unit '$per_unit' in not valid. Available: " . implode(', ', $units));
        }

        $this->per_unit = $per_unit;
        $this->per_messages = max(0, $messages);
        $this->per_value = max(1, $per_value);

        return $this;
    }


    public function schedule(Base $message): void
    {
        $message->schedule = $this->datetime_working->getTimestamp();

        if ($this->per_messages > 0 && (++ $this->counter % $this->per_messages === 0))
        {
            $this->datetime_working->modify("+$this->per_value $this->per_unit");
            $this->counter = 0;
        }
    }


    public function reset(): void
    {
        $this->datetime_working = clone $this->datetime;
        $this->counter = 0;
    }
}
