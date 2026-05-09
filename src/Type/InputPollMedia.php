<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpollmedia
 *
 * @api
 */
interface InputPollMedia
{
    public function getType(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array;
}
