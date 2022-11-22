<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\{Iterator, Strict};

class Bulk extends Iterator implements Send
{
    use Strict;


    /**
     * @param array<array-key, Base> $messages
     */
    public function __construct(array $messages = [])
    {
        foreach ($messages as $k => $message)
        {
            $this[$k] = $message;
        }
    }


    public function offsetSet($offset, $value): void
    {
        if ($value instanceof Base)
        {
            parent::offsetSet($offset, $value);
        }
    }


    public function jsonSerialize(): array
    {
        return ['messages' => parent::jsonSerialize()];
    }
}
