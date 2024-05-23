<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Base, Message\Channel, Message\Component\Button, Message\Component\Image};

class ViberConfigurator implements Configurator
{
	use Strict;

	public string $sender;

	public Button|null $button = null;

	public Image|null $image = null;

	/**
	 * @var int<60, max>|null
	 */
	public int|null $expiration = null;


	public function __construct(string $sender)
	{
		$this->sender = $sender;
	}


	public function button(string $caption, string $url): void
	{
		$this->button = new Button($caption, $url);
	}


	public function image(string $url, bool $zoom = false): void
	{
		$this->image = new Image($url, $zoom);
	}


	/**
	 * @param int<60, max>|null $expiration
	 */
	public function expiration(?int $expiration): void
	{
		$this->expiration = $expiration;
	}


	public function configure(Base $message): void
	{
		$message->configure(Channel::viber, $this->sender, $this->expiration);
	}


	public function getChannel(): string
	{
		return Channel::viber;
	}
}
