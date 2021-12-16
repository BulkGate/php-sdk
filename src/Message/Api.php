<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Api implements Send
{
    use Strict;

    /** @var array<mixed> */
    private array $data;


    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
