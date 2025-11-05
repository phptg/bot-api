<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmedia
 *
 * @api
 */
interface InputPaidMedia
{
    public function getType(): string;

    public function toRequestArray(?FileCollector $fileCollector = null): array;
}
