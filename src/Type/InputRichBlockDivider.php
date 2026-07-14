<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockdivider
 *
 * @api
 */
final readonly class InputRichBlockDivider implements InputRichBlock
{
    public function getType(): string
    {
        return 'divider';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
