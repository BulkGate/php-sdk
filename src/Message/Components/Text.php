<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

interface Text
{
    /**
     * @param array<string, scalar|null> $variables
     */
    public function text(string $text, array $variables = []): self;
}
