<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

class MockCallCounter
{
    public static array $callstack = [];


    public static function reset(): void
    {
        self::$callstack = [];
    }
}


/**
 * @return resource|false a file pointer resource on success, or false on error.
 */
function fopen(...$parameters)
{
    MockCallCounter::$callstack['fopen'][] = [$parameters];

    if ($parameters[0] === 'api://sdk/success')
    {
        return 'success';
    }
    else if ($parameters[0] === 'api://sdk/invalid')
    {
        return 'invalid';
    }

    return false;
}



function stream_context_create(...$parameters)
{
    MockCallCounter::$callstack['stream_context_create'][] = [$parameters];

    return true;
}


/**
 * @return string|false
 */
function stream_get_contents(...$parameters)
{
    MockCallCounter::$callstack['stream_get_contents'][] = [$parameters];

    return '{"data":{"status":"accepted","message_id":"sms-xxxtgkinpxu4","part_id":["sms-xxxtgkinpxu4"],"number":"420777777777","channel":"sms"}}';
}


/**
 * @return array|false
 */
function stream_get_meta_data(...$parameters)
{
    MockCallCounter::$callstack['stream_get_meta_data'][] = [$parameters];

    if ($parameters[0] === 'success')
    {
        return [
            'wrapper_data' => [
                'HTTP/1.1 200 OK',
                'Date: Fri, 17 Dec 2021 08:13:21 GMT',
                'Content-Type: application/json; charset=utf-8',
                'Connection: close',
                'X-Powered-By: 1.21 gigawatts',
                'Server: DeLorean time machine',
            ]
        ];
    }
    return [];
}


function fclose(...$parameters)
{
    MockCallCounter::$callstack['fclose'][] = [$parameters];

    return true;
}
