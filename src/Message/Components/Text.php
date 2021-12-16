<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

interface Text
{
    /**
     * @param array<float|int|string> $variables
     */
    public function text(string $text, array $variables = []): self;
}
