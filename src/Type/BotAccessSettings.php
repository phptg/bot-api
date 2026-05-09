<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#botaccesssettings
 *
 * @api
 */
final readonly class BotAccessSettings
{
    /**
     * @param User[]|null $addedUsers
     */
    public function __construct(
        public bool $isAccessRestricted,
        #[ArrayOfObjectsValue(User::class)]
        public ?array $addedUsers = null,
    ) {}
}
