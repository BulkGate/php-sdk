<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\{Base, Channel};

class RcsConfigurator implements Configurator
{
	public function __construct(protected string|null $sender, protected int|null $timeout = null)
	{
	}


	/**
	 * @param string $sender
	 */
	public function sender(string $sender): void
	{
		$this->sender = $sender;
	}


	/**
	 * @param int<60, max> $expiration
	 */
	public function expiration(int $expiration): void
	{
		$this->timeout = $expiration;
	}


	public function configure(Base $message): void
	{
		$message->configure(Channel::RCS, $this->sender, $this->timeout);
	}


	public function getChannel(): string
	{
		return Channel::RCS;
	}
}
