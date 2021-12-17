<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\ApiException;
use BulkGate\Sdk\Utils\{CompressJson, Json, Strict};
use Throwable;

class Response
{
    use Strict;

    /** @var array<mixed> */
    private array $data = [];

    /** @var array<callable> */
    public array $decoders = [];

    /** @var array<mixed>|null */
    private ?array $error = null;


    public function __construct(?string $content_type, string $data)
    {
        $this->decoders['application/json'] = fn (string $data) => Json::decode($data);
        $this->decoders['application/base64+gzip+json'] = fn (string $data) => CompressJson::decode($data);

        if (isset($this->decoders[$content_type]))
        {
            try
            {
                $data = $this->decoders[$content_type]($data);
            }
            catch (Throwable $e)
            {
                $data = null;
            }

            if (is_array($data))
            {
                if (isset($data['error']))
                {
                    $this->error = $data;
                }
                else if (isset($data['data']))
                {
                    if (isset($data['data']['response']))
                    {
                        $this->data = $data['data']['response'];
                    }
                    else
                    {
                        $this->data = $data['data'];
                    }

                    $this->error = null;
                }
                else
                {
                    $this->error = [
                        'type' => 'unknown',
                        'error' => 'Unknown API Response',
                        'code' => 400,
                        'detail' => null
                    ];
                }
            }
            else
            {
                $this->error = [
                    'type' => 'malformed_response',
                    'error' => 'Server response is malformed.',
                    'code' => 400,
                    'detail' => null
                ];
            }
        }
    }


    /**
     * @return array<mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }


    public function isSuccess(): bool
    {
        return $this->error === null;
    }


    /**
     * @throws ApiException
     */
    public function checkException(): void
    {
        if (!$this->isSuccess())
        {
            throw new ApiException(
                $this->error['detail'] ?? $this->error['error'] ?? 'API Error',
                $this->error['code'] ?? 0
            );
        }
    }
}
