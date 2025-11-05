<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\PaidMedia;
use Phptg\BotApi\Type\PaidMediaPhoto;
use Phptg\BotApi\Type\PaidMediaPreview;
use Phptg\BotApi\Type\PaidMediaVideo;

/**
 * @template-extends InterfaceValue<PaidMedia>
 */
final readonly class PaidMediaValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'preview' => PaidMediaPreview::class,
            'photo' => PaidMediaPhoto::class,
            'video' => PaidMediaVideo::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown paid media type.';
    }
}
