<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

class SdkException extends \Exception
{
}


class TypeError extends \Exception /* @php8 TypeError */
{
}


class ChannelException extends SdkException
{
}


class SenderException extends SdkException
{
}


class ConnectionException extends SenderException
{
}


class InvalidStateException extends SdkException
{
}


class ApiException extends SdkException
{
}
