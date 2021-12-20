<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{
    Message\Channel,
    Utils\Strict,
    Message\Component\Button,
    Message\Component\Image,
    Message\Component\SimpleText
};
use function array_pad;

class Viber implements Settings
{
    use Strict;

    public const DEFAULT_RESEND_TIMEOUT = 10_800;

    public SimpleText $text;

    public ?string $sender;

    public ?Button $button;

    public ?Image $image;

    public ?int $timeout;


    public function __construct(SimpleText $text, ?string $sender = null, ?Button $button = null, ?Image $image = null, int $timeout = null)
    {
        $this->text = $text;
        $this->sender = $sender;
        $this->button = $button;
        $this->image = $image;
        $this->timeout = $timeout;
    }


    public function configure(...$parameters): void
    {
        [$channel, $sender, $button, $image, $timeout] = array_pad($parameters, 5, null);

        if ($channel === Channel::VIBER)
        {
            $this->sender ??= $sender;
            $this->button ??= $button;
            $this->image ??= $image;
            $this->timeout ??= $timeout;
        }
    }


    /**
     * @return array<mixed>
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
            'expiration' => $this->timeout ?? self::DEFAULT_RESEND_TIMEOUT
        ];
    }
}
