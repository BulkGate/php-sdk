<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Api implements Send
{
    use Strict;

    /**
     * @var array<array-key, mixed>
     */
    private array $data;


    /**
     * @param array<array-key, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }


    /**
     * @return array<array-key, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
