<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2025 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{ConnectionException, Utils\Strict};
use function array_key_exists, implode, restore_error_handler, set_error_handler;

class ConnectionStream implements Connection
{
    use Strict;

    private int $application_id;

    private string $application_token;

    private string $application_product;

    private string $api;

    private string $content_type;


    public function __construct(
		int $application_id,
		string $application_token,
		string $api = 'https://portal.bulkgate.com/api/1.0/integration',
		string $application_product = 'php-sdk',
		string $content_type = 'application/json'
    )
    {
        $this->application_id = $application_id;
        $this->application_token = $application_token;
        $this->api = $api;
        $this->application_product = $application_product;
        $this->content_type = $content_type;
    }


    /**
     * @throws ConnectionException
     */
    public function send(Request $request): Response
    {
		try
		{
			set_error_handler(function (int $error_code, string $error_message): void { throw new ConnectionException($error_message, $error_code);	});

			[$content_type, $action, $data] = $request->encode($this->content_type, [
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

					if (array_key_exists('wrapper_data', $meta))
					{
						return new Response(Helpers::parseContentType(implode("\n" , $meta['wrapper_data'])), $response, Helpers::parseHttpCode($meta['wrapper_data'][0] ?? null));
					}
				}
				finally
				{
					fclose($connection);
				}
			}
		}
		finally
		{
			restore_error_handler();
		}

	    throw new ConnectionException("BulkGate server is unavailable - $this->api/$action");
    }
}
