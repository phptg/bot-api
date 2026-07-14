<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockmathematicalexpression
 *
 * @api
 */
final readonly class InputRichBlockMathematicalExpression implements InputRichBlock
{
    public function __construct(
        public string $expression,
    ) {}

    public function getType(): string
    {
        return 'mathematical_expression';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'expression' => $this->expression,
        ];
    }
}
