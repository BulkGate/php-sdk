<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Component\PhoneNumber, Utils\Strict};

abstract class Base implements Message, Send
{
	use Strict;

	public Component\PhoneNumber $phone_number;

	public int|null $schedule = null;

	public string $status = 'preparation';

	public string|null $message_id = null;

	/**
	 * @var array<int, string>|null
	 */
	public array|null $part_id = null;

	public string|null $error = null;


	/**
	 * @param Component\PhoneNumber|string $phone_number
	 */
	public function __construct(PhoneNumber|string $phone_number)
	{
		$this->phone_number = Helpers::createNumber($phone_number);
	}


	/**
	 * @param mixed ...$parameters
	 */
	abstract public function configure(...$parameters): void;


	/**
	 * @param array<int, string>|null $part_id
	 */
	public function updateStatus(string $status, string|null $message_id, array|null $part_id, string|null $error = null): void
	{
		$this->status = $status;
		$this->message_id = $message_id;
		$this->part_id = $part_id;
		$this->error = $error;
	}


	public function __toString(): string
	{
		return "$this->phone_number";
	}
}
