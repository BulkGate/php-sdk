<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Send, Configurator\Configurator};

interface Sender
{
    public function addSenderConfigurator(Configurator $configurator): void;


    public function send(Send $message): Send;
}
