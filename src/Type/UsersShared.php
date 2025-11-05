<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#usersshared
 *
 * @api
 */
final readonly class UsersShared
{
    /**
     * @param int $requestId
     * @param SharedUser[] $users
     */
    public function __construct(
        public int $requestId,
        #[ArrayOfObjectsValue(SharedUser::class)]
        public array $users,
    ) {}
}
