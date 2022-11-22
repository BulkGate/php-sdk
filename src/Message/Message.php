<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

interface Message
{
    /**
     * @return array<int, string>
     */
    public function getChannels(): array;
}
