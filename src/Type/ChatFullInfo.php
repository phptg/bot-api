<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ReactionTypeValue;
use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#chatfullinfo
 *
 * @api
 */
final readonly class ChatFullInfo
{
    /**
     * @param string[]|null $activeUsernames
     * @param ReactionType[]|null $availableReactions
     */
    public function __construct(
        public int $id,
        public string $type,
        public int $accentColorId,
        public int $maxReactionCount,
        public ?string $title = null,
        public ?string $username = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?true $isForum = null,
        public ?ChatPhoto $photo = null,
        #[ArrayMap(StringValue::class)]
        public ?array $activeUsernames = null,
        public ?Birthdate $birthdate = null,
        public ?BusinessIntro $businessIntro = null,
        public ?BusinessLocation $businessLocation = null,
        public ?BusinessOpeningHours $businessOpeningHours = null,
        public ?Chat $personalChat = null,
        #[ArrayMap(ReactionTypeValue::class)]
        public ?array $availableReactions = null,
        public ?string $backgroundCustomEmojiId = null,
        public ?int $profileAccentColorId = null,
        public ?string $profileBackgroundCustomEmojiId = null,
        public ?string $emojiStatusCustomEmojiId = null,
        public ?DateTimeImmutable $emojiStatusExpirationDate = null,
        public ?string $bio = null,
        public ?true $hasPrivateForwards = null,
        public ?true $hasRestrictedVoiceAndVideoMessages = null,
        public ?true $joinToSendMessages = null,
        public ?true $joinByRequest = null,
        public ?string $description = null,
        public ?string $inviteLink = null,
        public ?Message $pinnedMessage = null,
        public ?ChatPermissions $permissions = null,
        public ?int $slowModeDelay = null,
        public ?int $unrestrictBoostCount = null,
        public ?int $messageAutoDeleteTime = null,
        public ?true $hasAggressiveAntiSpamEnabled = null,
        public ?true $hasHiddenMembers = null,
        public ?true $hasProtectedContent = null,
        public ?true $hasVisibleHistory = null,
        public ?string $stickerSetName = null,
        public ?true $canSetStickerSet = null,
        public ?string $customEmojiStickerSetName = null,
        public ?int $linkedChatId = null,
        public ?ChatLocation $location = null,
        public ?true $canSendPaidMedia = null,
        public ?AcceptedGiftTypes $acceptedGiftTypes = null,
        public ?true $isDirectMessages = null,
        public ?Chat $parentChat = null,
        public ?UserRating $rating = null,
        public ?UniqueGiftColors $uniqueGiftColors = null,
        public ?int $paidMessageStarCount = null,
        public ?Audio $firstProfileAudio = null,
    ) {}
}
