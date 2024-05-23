<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

use BulkGate\Sdk\Message\Component\SimpleText;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

/**
 * @property SimpleText $text
 */
interface Viber extends Settings
{
	public const DefaultExpiration = 60;


	public function getText(): SimpleText|null;
}
