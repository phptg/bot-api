<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockdocument
 *
 * @api
 */
final readonly class RichBlockDocument implements RichBlock
{
    public function __construct(
        public Document $document,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'document';
    }
}
