<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;


/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use JsonSerializable;

interface Settings extends JsonSerializable
{
    /**
     * @param mixed ...$parameters
     */
    public function configure(...$parameters): void;
}
