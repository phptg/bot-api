<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmedialink
 *
 * @api
 */
final readonly class InputMediaLink implements InputPollOptionMedia
{
    public function __construct(
        public string $url,
    ) {}

    public function getType(): string
    {
        return 'link';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'url' => $this->url,
        ];
    }
}
