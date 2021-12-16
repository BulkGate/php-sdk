<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Send, Utils\CompressJson, Utils\Json, Utils\Strict};

class Request
{
    use Strict;

    private string $action;

    private Send $send;

    /** @var array<mixed> */
    private array $parameters;

    /** @var array<callable> */
    public array $encoders = [];


    /**
     * @param array<mixed> $parameters
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
     * @param array<mixed> $data
     * @return array<mixed>
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
