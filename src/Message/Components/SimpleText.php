<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class SimpleText implements Text
{
    use Strict;

    public string $text = '';

    /** @var array<float|int|string> */
    public array $variables = [];


    /**
     * @param array<float|int|string> $variables
     */
    public function __construct(?string $text = null, array $variables = [])
    {
        if ($text !== null)
        {
            $this->text($text, $variables);
        }
    }


    public function text(string $text, array $variables = []): self
    {
        $this->text = $text;
        $this->variables = $variables;

        return $this;
    }


    public function __toString(): string
    {
        return $this->text;
    }
}
