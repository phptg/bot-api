<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichmessagemedia
 *
 * @api
 */
final readonly class InputRichMessageMedia
{
    public function __construct(
        public string $id,
        public InputMediaAnimation|InputMediaAudio|InputMediaPhoto|InputMediaVideo|InputMediaVoiceNote $media,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'id' => $this->id,
            'media' => $this->media->toRequestArray($fileCollector),
        ];
    }
}
