<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Channel, Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\SimpleText, Sdk\Utils\Strict};
use function array_pad;

class ViberCard implements Viber
{
	use Strict;

	/**
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public readonly SimpleText $text,
		public int|null $timeout = null,
		public string|null $sender = null,
		public readonly Button|null $button = null,
		public readonly Image|null $image = null,
	)
	{
	}


	public function configure(...$parameters): void
	{
		/*if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::Viber && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60 ) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::Viber)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}*/

		[$this->sender, $this->timeout] = Helpers::configureGeneral($this->sender, $this->timeout, ...$parameters);
	}


	public function getText(): SimpleText
	{
		return $this->text;
	}


	/**
	 * @return array{text: string, variables: array<string, scalar|null>, sender: string|null, button_caption: string, button_url: string|null, image: string|null, image_zoom: bool, expiration: int}
	 */
	public function jsonSerialize(): array
	{
		return [
			'text' => $this->text->text,
			'variables' => $this->text->variables,
			'sender' => $this->sender,
			'button_caption' => $this->button instanceof Button ? $this->button->caption : 'OK',
			'button_url' => $this->button instanceof Button ? $this->button->url : '#',
			'image' => $this->image instanceof Image ? $this->image->url : null,
			'image_zoom' => $this->image instanceof Image ? $this->image->zoom : false,
			'expiration' => $this->timeout ?? self::DefaultExpiration
		];
	}
}
