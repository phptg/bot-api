<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#botfullinfo
 *
 * @api
 */
final readonly class BotFullInfo
{
    /**
     * @param string[]|null $activeUsernames
     */
    public function __construct(
        public int $id,
        public true $isBot,
        public string $firstName,
        public bool $canJoinGroups,
        public bool $canReadAllGroupMessages,
        public bool $supportsGuestQueries,
        public bool $supportsInlineQueries,
        public bool $needsInlineQueryLocation,
        public bool $canConnectToBusiness,
        public bool $hasMainWebApp,
        public bool $hasTopicsEnabled,
        public bool $allowsUsersToCreateTopics,
        public bool $hasTopicSidebar,
        public bool $canManageBots,
        public bool $supportsJoinRequestQueries,
        public ?string $username = null,
        #[ArrayMap(StringValue::class)]
        public ?array $activeUsernames = null,
        public ?string $inlineQueryPlaceholder = null,
    ) {}
}
