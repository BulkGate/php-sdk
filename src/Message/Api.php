<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Api implements Send
{
    use Strict;


    /**
     * @param array<array-key, mixed> $data
     */
    public function __construct(private readonly array $data = [])
    {
    }


    /**
     * @return array<array-key, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
