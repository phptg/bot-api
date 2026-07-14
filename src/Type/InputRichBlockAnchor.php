<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockanchor
 *
 * @api
 */
final readonly class InputRichBlockAnchor implements InputRichBlock
{
    public function __construct(
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'anchor';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->name,
        ];
    }
}
