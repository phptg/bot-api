<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#videochatparticipantsinvited
 *
 * @api
 */
final readonly class VideoChatParticipantsInvited
{
    /**
     * @param User[] $users
     */
    public function __construct(
        #[ArrayOfObjectsValue(User::class)]
        public array $users,
    ) {}
}
