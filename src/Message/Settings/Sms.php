<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Channel, Sdk\Message\Component\SmsSender, Sdk\Utils\Strict, Sdk\Message\Component\SimpleText};
use function array_pad;

class Sms implements Settings
{
	use Strict;

	public function __construct(public readonly SimpleText $text, public string|null $sender_id = null, public string|null $sender_id_value = null, public bool|null $unicode = null)
	{
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender_id, $sender_id_value, $unicode] = array_pad($parameters, 4, null);

			if ($channel === Channel::SMS && (is_string($sender_id) || is_null($sender_id)) && (is_string($sender_id_value) || is_null($sender_id_value)) && (is_bool($unicode) || is_null($unicode)))
			{
				$this->sender_id ??= $sender_id;
				$this->sender_id_value ??= $sender_id_value;
				$this->unicode ??= $unicode;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::SMS)
		{
			$this->sender_id ??= isset($parameters['sender_id']) && is_string($parameters['sender_id']) ? $parameters['sender_id'] : $this->sender_id;
			$this->sender_id_value ??= isset($parameters['sender_id_value']) && is_string($parameters['sender_id_value']) ? $parameters['sender_id_value'] : $this->sender_id_value;
			$this->unicode ??= isset($parameters['unicode']) && is_bool($parameters['unicode']) ? $parameters['unicode'] : $this->unicode;
		}
	}


	/**
	 * @return array{text: string, variables: array<string, scalar|null>, sender_id: string, sender_id_value: string, unicode: bool}
	 */
	public function jsonSerialize(): array
	{
		return [
			'text' => $this->text->text,
			'variables' => $this->text->variables,
			'sender_id' => $this->sender_id ?? SmsSender::GATE_SYSTEM_NUMBER,
			'sender_id_value' => $this->sender_id_value ?? SmsSender::DEFAULT_SENDER,
			'unicode' => $this->unicode ?? false
		];
	}
}
