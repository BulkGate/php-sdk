<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use DateTime;
use BulkGate\Sdk\{Message\Base, Utils\Strict};

class Simple implements Scheduler
{
    use Strict;

    private DateTime $datetime;


    public function __construct(DateTime $datetime)
    {
        $this->datetime = $datetime;
    }


    public function schedule(Base $message): void
    {
        $message->schedule = $this->datetime->getTimestamp();
    }
}
