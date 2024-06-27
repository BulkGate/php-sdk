<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
class ButtonQuickReplyPayload implements Button
{
	public function __construct(public int $index, public string $payload)
	{
	}


	public function serialize(): array
	{
		return [
			'type' => 'payload',
			'index' => $this->index,
			'payload' => $this->payload
		];
	}
}
