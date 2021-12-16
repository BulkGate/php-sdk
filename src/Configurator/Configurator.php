<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Send;

interface Configurator
{
    public function configure(Send $message): void;


    public function getChannel(): string;
}
