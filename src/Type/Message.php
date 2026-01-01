<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\MaybeInaccessibleMessageValue;
use Phptg\BotApi\Type\Game\Game;
use Phptg\BotApi\Type\Passport\PassportData;
use Phptg\BotApi\Type\Payment\Invoice;
use Phptg\BotApi\Type\Payment\RefundedPayment;
use Phptg\BotApi\Type\Payment\SuccessfulPayment;
use Phptg\BotApi\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#message
 *
 * @api
 */
final readonly class Message
{
    /**
     * @param MessageEntity[]|null $entities
     * @param PhotoSize[]|null $photo
     * @param MessageEntity[]|null $captionEntities
     * @param User[]|null $newChatMembers
     * @param PhotoSize[]|null $newChatPhoto
     */
    public function __construct(
        public int $messageId,
        public DateTimeImmutable $date,
        public Chat $chat,
        public ?int $messageThreadId = null,
        public ?User $from = null,
        public ?Chat $senderChat = null,
        public ?int $senderBoostCount = null,
        public ?User $senderBusinessBot = null,
        public ?string $businessConnectionId = null,
        public ?MessageOrigin $forwardOrigin = null,
        public ?true $isTopicMessage = null,
        public ?true $isAutomaticForward = null,
        public ?Message $replyToMessage = null,
        public ?ExternalReplyInfo $externalReply = null,
        public ?TextQuote $quote = null,
        public ?Story $replyToStory = null,
        public ?User $viaBot = null,
        public ?DateTimeImmutable $editDate = null,
        public ?true $hasProtectedContent = null,
        public ?true $isFromOffline = null,
        public ?string $mediaGroupId = null,
        public ?string $authorSignature = null,
        public ?int $paidStarCount = null,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?LinkPreviewOptions $linkPreviewOptions = null,
        public ?string $effectId = null,
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
        public ?Sticker $sticker = null,
        public ?Story $story = null,
        public ?Video $video = null,
        public ?VideoNote $videoNote = null,
        public ?Voice $voice = null,
        public ?string $caption = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $captionEntities = null,
        public ?true $showCaptionAboveMedia = null,
        public ?true $hasMediaSpoiler = null,
        public ?Contact $contact = null,
        public ?Dice $dice = null,
        public ?Game $game = null,
        public ?Poll $poll = null,
        public ?Venue $venue = null,
        public ?Location $location = null,
        #[ArrayOfObjectsValue(User::class)]
        public ?array $newChatMembers = null,
        public ?User $leftChatMember = null,
        public ?string $newChatTitle = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $newChatPhoto = null,
        public ?true $deleteChatPhoto = null,
        public ?true $groupChatCreated = null,
        public ?true $supergroupChatCreated = null,
        public ?true $channelChatCreated = null,
        public ?MessageAutoDeleteTimerChanged $messageAutoDeleteTimerChanged = null,
        public ?int $migrateToChatId = null,
        public ?int $migrateFromChatId = null,
        #[MaybeInaccessibleMessageValue]
        public Message|InaccessibleMessage|null $pinnedMessage = null,
        public ?Invoice $invoice = null,
        public ?SuccessfulPayment $successfulPayment = null,
        public ?UsersShared $usersShared = null,
        public ?ChatShared $chatShared = null,
        public ?GiftInfo $gift = null,
        public ?UniqueGiftInfo $uniqueGift = null,
        public ?GiftInfo $giftUpgradeSent = null,
        public ?string $connectedWebsite = null,
        public ?WriteAccessAllowed $writeAccessAllowed = null,
        public ?PassportData $passportData = null,
        public ?ProximityAlertTriggered $proximityAlertTriggered = null,
        public ?ChatBoostAdded $boostAdded = null,
        public ?ChatBackground $chatBackgroundSet = null,
        public ?ForumTopicCreated $forumTopicCreated = null,
        public ?ForumTopicEdited $forumTopicEdited = null,
        public ?ForumTopicClosed $forumTopicClosed = null,
        public ?ForumTopicReopened $forumTopicReopened = null,
        public ?GeneralForumTopicHidden $generalForumTopicHidden = null,
        public ?GeneralForumTopicUnhidden $generalForumTopicUnhidden = null,
        public ?GiveawayCreated $giveawayCreated = null,
        public ?Giveaway $giveaway = null,
        public ?GiveawayWinners $giveawayWinners = null,
        public ?GiveawayCompleted $giveawayCompleted = null,
        public ?PaidMessagePriceChanged $paidMessagePriceChanged = null,
        public ?VideoChatScheduled $videoChatScheduled = null,
        public ?VideoChatStarted $videoChatStarted = null,
        public ?VideoChatEnded $videoChatEnded = null,
        public ?VideoChatParticipantsInvited $videoChatParticipantsInvited = null,
        public ?WebAppData $webAppData = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?PaidMediaInfo $paidMedia = null,
        public ?RefundedPayment $refundedPayment = null,
        public ?DirectMessagePriceChanged $directMessagePriceChanged = null,
        public ?Checklist $checklist = null,
        public ?ChecklistTasksDone $checklistTasksDone = null,
        public ?ChecklistTasksAdded $checklistTasksAdded = null,
        public ?int $replyToChecklistTaskId = null,
        public ?DirectMessagesTopic $directMessagesTopic = null,
        public ?true $isPaidPost = null,
        public ?SuggestedPostInfo $suggestedPostInfo = null,
        public ?SuggestedPostApproved $suggestedPostApproved = null,
        public ?SuggestedPostApprovalFailed $suggestedPostApprovalFailed = null,
        public ?SuggestedPostDeclined $suggestedPostDeclined = null,
        public ?SuggestedPostPaid $suggestedPostPaid = null,
        public ?SuggestedPostRefunded $suggestedPostRefunded = null,
    ) {}
}
