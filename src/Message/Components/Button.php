<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Button
{
    use Strict;

    public string $caption;

    public string $url;


    public function __construct(string $caption, string $url)
    {
        $this->caption = $caption;
        $this->url = $url;
    }
}

