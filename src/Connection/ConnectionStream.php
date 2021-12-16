<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{ConnectionException, Utils\Strict};
use function implode, fopen, fclose, stream_context_create, stream_get_contents, stream_get_meta_data;

class ConnectionStream implements Connection
{
    use Strict;

    private int $application_id;

    private string $application_token;

    private string $application_product;

    private string $api;


    public function __construct(int $application_id, string $application_token, string $api = 'https://portal.bulkgate.com/api/1.0/integration', string $application_product = 'php-sdk')
    {
        $this->application_id = $application_id;
        $this->application_token = $application_token;
        $this->api = $api;
        $this->application_product = $application_product;
    }


    /**
     * @throws ConnectionException
     */
    public function send(Request $request): Response
    {
        [$content_type, $action, $data] = $request->encode('application/json', [
            'application_id' => $this->application_id,
            'application_token' => $this->application_token,
            'application_product' => $this->application_product
        ]);

        $context = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => [
                "Content-type: $content_type"
            ],
            'content' => $data,
            'ignore_errors' => true
        ]]);

        $connection = fopen("$this->api/$action", 'r', false, $context);

        if ($connection)
        {
            try
            {
                $response = (string) stream_get_contents($connection);

                $meta = stream_get_meta_data($connection);

                if (isset($meta['wrapper_data']))
                {
                    return new Response(Helpers::parseContentType(implode("\n" , $meta['wrapper_data'])), $response);
                }
            }
            finally
            {
                fclose($connection);
            }
        }

        throw new ConnectionException("BulkGate server is unavailable - $this->api/$action");
    }
}
