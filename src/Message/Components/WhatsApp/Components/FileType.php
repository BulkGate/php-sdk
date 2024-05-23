<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;


/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
enum FileType: string
{
	case Image = 'image';

	case Video = 'video';

	case Audio = 'audio';

	case Document = 'document';

	case Sticker = 'sticker';


	public function serialize(): string
	{
		return strtoupper($this->value);
	}
}
