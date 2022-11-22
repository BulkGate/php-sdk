<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Base, Utils\Strict};

class None implements Scheduler
{
    use Strict;


    public function schedule(Base $message): void
    {
    }
}
