<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class Image
{
    use Strict;

    public string $url;

    public bool $zoom;


    public function __construct(string $url, bool $zoom = false)
    {
        $this->url = $url;
        $this->zoom = $zoom;
    }
}
