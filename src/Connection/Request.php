<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Send, Utils\CompressJson, Utils\Json, Utils\Strict};
use function array_merge;

class Request
{
    use Strict;

    private string $action;

    private Send $send;

    /**
     * @var array<array-key, mixed>
     */
    private array $parameters;

    /**
     * @var array<array-key, callable>
     */
    public array $encoders = [];


    /**
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(string $action, Send $send, array $parameters = [])
    {
        $this->action = $action;
        $this->send = $send;
        $this->parameters = $parameters;
        $this->encoders['application/json'] = fn ($data) => Json::encode($data);
        $this->encoders['application/base64+gzip+json'] = fn ($data) => CompressJson::encode($data);
    }


    /**
     * @param array<array-key, mixed> $data
     * @return array{string, string, array<array-key, mixed>}
     */
    public function encode(string $content_type = 'application/json', array $data = []): array
    {
        if (!isset($this->encoders[$content_type]))
        {
            $content_type = 'application/json';
        }

        $data = array_merge($data, $this->send->jsonSerialize(), $this->parameters);

        return [$content_type, $this->action, $this->encoders[$content_type]($data)];
    }
}
