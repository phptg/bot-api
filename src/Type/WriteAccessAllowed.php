<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#writeaccessallowed
 *
 * @api
 */
final readonly class WriteAccessAllowed
{
    public function __construct(
        public ?bool $fromRequest = null,
        public ?string $webAppName = null,
        public ?bool $fromAttachmentMenu = null,
    ) {}
}
