<?php

declare(strict_types=1);

namespace Phptg\BotApi;

use DateTimeImmutable;
use DateTimeInterface;
use LogicException;
use Psr\Log\LoggerInterface;
use SensitiveParameter;
use Phptg\BotApi\Method\AnswerCallbackQuery;
use Phptg\BotApi\Method\ApproveChatJoinRequest;
use Phptg\BotApi\Method\ApproveSuggestedPost;
use Phptg\BotApi\Method\BanChatMember;
use Phptg\BotApi\Method\BanChatSenderChat;
use Phptg\BotApi\Method\Close;
use Phptg\BotApi\Method\CloseForumTopic;
use Phptg\BotApi\Method\CloseGeneralForumTopic;
use Phptg\BotApi\Method\ConvertGiftToStars;
use Phptg\BotApi\Method\CopyMessage;
use Phptg\BotApi\Method\CopyMessages;
use Phptg\BotApi\Method\CreateChatInviteLink;
use Phptg\BotApi\Method\CreateChatSubscriptionInviteLink;
use Phptg\BotApi\Method\CreateForumTopic;
use Phptg\BotApi\Method\DeclineChatJoinRequest;
use Phptg\BotApi\Method\DeclineSuggestedPost;
use Phptg\BotApi\Method\DeleteChatPhoto;
use Phptg\BotApi\Method\DeleteChatStickerSet;
use Phptg\BotApi\Method\DeleteForumTopic;
use Phptg\BotApi\Method\DeleteMyCommands;
use Phptg\BotApi\Method\DeleteStory;
use Phptg\BotApi\Method\EditChatInviteLink;
use Phptg\BotApi\Method\EditChatSubscriptionInviteLink;
use Phptg\BotApi\Method\EditForumTopic;
use Phptg\BotApi\Method\EditGeneralForumTopic;
use Phptg\BotApi\Method\EditStory;
use Phptg\BotApi\Method\ExportChatInviteLink;
use Phptg\BotApi\Method\ForwardMessage;
use Phptg\BotApi\Method\ForwardMessages;
use Phptg\BotApi\Method\Game\GetGameHighScores;
use Phptg\BotApi\Method\Game\SendGame;
use Phptg\BotApi\Method\Game\SetGameScore;
use Phptg\BotApi\Method\GetBusinessAccountGifts;
use Phptg\BotApi\Method\GetBusinessAccountStarBalance;
use Phptg\BotApi\Method\GetBusinessConnection;
use Phptg\BotApi\Method\GetChat;
use Phptg\BotApi\Method\GetChatGifts;
use Phptg\BotApi\Method\GetChatAdministrators;
use Phptg\BotApi\Method\GetChatMember;
use Phptg\BotApi\Method\GetChatMemberCount;
use Phptg\BotApi\Method\GetChatMenuButton;
use Phptg\BotApi\Method\GetFile;
use Phptg\BotApi\Method\GetForumTopicIconStickers;
use Phptg\BotApi\Method\GetMe;
use Phptg\BotApi\Method\GetMyCommands;
use Phptg\BotApi\Method\GetMyDefaultAdministratorRights;
use Phptg\BotApi\Method\GetMyDescription;
use Phptg\BotApi\Method\GetMyName;
use Phptg\BotApi\Method\GetMyShortDescription;
use Phptg\BotApi\Method\GetMyStarBalance;
use Phptg\BotApi\Method\GetUserChatBoosts;
use Phptg\BotApi\Method\GetUserGifts;
use Phptg\BotApi\Method\GetUserProfileAudios;
use Phptg\BotApi\Method\GetUserProfilePhotos;
use Phptg\BotApi\Method\GiftPremiumSubscription;
use Phptg\BotApi\Method\HideGeneralForumTopic;
use Phptg\BotApi\Method\Inline\AnswerInlineQuery;
use Phptg\BotApi\Method\Inline\AnswerWebAppQuery;
use Phptg\BotApi\Method\Inline\SavePreparedInlineMessage;
use Phptg\BotApi\Method\LeaveChat;
use Phptg\BotApi\Method\LogOut;
use Phptg\BotApi\Method\Passport\SetPassportDataErrors;
use Phptg\BotApi\Method\Payment\AnswerPreCheckoutQuery;
use Phptg\BotApi\Method\Payment\AnswerShippingQuery;
use Phptg\BotApi\Method\Payment\CreateInvoiceLink;
use Phptg\BotApi\Method\Payment\EditUserStarSubscription;
use Phptg\BotApi\Method\Payment\GetStarTransactions;
use Phptg\BotApi\Method\Payment\RefundStarPayment;
use Phptg\BotApi\Method\Payment\SendInvoice;
use Phptg\BotApi\Method\PinChatMessage;
use Phptg\BotApi\Method\PostStory;
use Phptg\BotApi\Method\PromoteChatMember;
use Phptg\BotApi\Method\RepostStory;
use Phptg\BotApi\Method\RemoveBusinessAccountProfilePhoto;
use Phptg\BotApi\Method\RemoveMyProfilePhoto;
use Phptg\BotApi\Method\RemoveChatVerification;
use Phptg\BotApi\Method\RemoveUserVerification;
use Phptg\BotApi\Method\ReopenForumTopic;
use Phptg\BotApi\Method\ReopenGeneralForumTopic;
use Phptg\BotApi\Method\RestrictChatMember;
use Phptg\BotApi\Method\RevokeChatInviteLink;
use Phptg\BotApi\Method\SendAnimation;
use Phptg\BotApi\Method\SendAudio;
use Phptg\BotApi\Method\SendChatAction;
use Phptg\BotApi\Method\SendChecklist;
use Phptg\BotApi\Method\SendContact;
use Phptg\BotApi\Method\SendDice;
use Phptg\BotApi\Method\SendDocument;
use Phptg\BotApi\Method\SendLocation;
use Phptg\BotApi\Method\SendMediaGroup;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\Method\SendMessageDraft;
use Phptg\BotApi\Method\SendPaidMedia;
use Phptg\BotApi\Method\SendPhoto;
use Phptg\BotApi\Method\SendPoll;
use Phptg\BotApi\Method\SendVenue;
use Phptg\BotApi\Method\SendVideo;
use Phptg\BotApi\Method\SendVideoNote;
use Phptg\BotApi\Method\SendVoice;
use Phptg\BotApi\Method\SetBusinessAccountBio;
use Phptg\BotApi\Method\SetBusinessAccountGiftSettings;
use Phptg\BotApi\Method\SetBusinessAccountName;
use Phptg\BotApi\Method\SetBusinessAccountProfilePhoto;
use Phptg\BotApi\Method\SetBusinessAccountUsername;
use Phptg\BotApi\Method\SetChatAdministratorCustomTitle;
use Phptg\BotApi\Method\SetChatDescription;
use Phptg\BotApi\Method\SetChatMenuButton;
use Phptg\BotApi\Method\SetChatPermissions;
use Phptg\BotApi\Method\SetChatPhoto;
use Phptg\BotApi\Method\SetChatStickerSet;
use Phptg\BotApi\Method\SetChatTitle;
use Phptg\BotApi\Method\SetMessageReaction;
use Phptg\BotApi\Method\SetMyCommands;
use Phptg\BotApi\Method\SetMyDefaultAdministratorRights;
use Phptg\BotApi\Method\SetMyDescription;
use Phptg\BotApi\Method\SetMyName;
use Phptg\BotApi\Method\SetMyProfilePhoto;
use Phptg\BotApi\Method\SetMyShortDescription;
use Phptg\BotApi\Method\SetUserEmojiStatus;
use Phptg\BotApi\Method\Sticker\AddStickerToSet;
use Phptg\BotApi\Method\Sticker\CreateNewStickerSet;
use Phptg\BotApi\Method\Sticker\DeleteStickerFromSet;
use Phptg\BotApi\Method\Sticker\DeleteStickerSet;
use Phptg\BotApi\Method\Sticker\GetAvailableGifts;
use Phptg\BotApi\Method\Sticker\GetCustomEmojiStickers;
use Phptg\BotApi\Method\Sticker\GetStickerSet;
use Phptg\BotApi\Method\Sticker\ReplaceStickerInSet;
use Phptg\BotApi\Method\Sticker\SendGift;
use Phptg\BotApi\Method\Sticker\SendSticker;
use Phptg\BotApi\Method\Sticker\SetCustomEmojiStickerSetThumbnail;
use Phptg\BotApi\Method\Sticker\SetStickerEmojiList;
use Phptg\BotApi\Method\Sticker\SetStickerKeywords;
use Phptg\BotApi\Method\Sticker\SetStickerMaskPosition;
use Phptg\BotApi\Method\Sticker\SetStickerPositionInSet;
use Phptg\BotApi\Method\Sticker\SetStickerSetThumbnail;
use Phptg\BotApi\Method\Sticker\SetStickerSetTitle;
use Phptg\BotApi\Method\Sticker\UploadStickerFile;
use Phptg\BotApi\Method\TransferBusinessAccountStars;
use Phptg\BotApi\Method\TransferGift;
use Phptg\BotApi\Method\UnbanChatMember;
use Phptg\BotApi\Method\UnbanChatSenderChat;
use Phptg\BotApi\Method\UnhideGeneralForumTopic;
use Phptg\BotApi\Method\UnpinAllChatMessages;
use Phptg\BotApi\Method\UnpinAllForumTopicMessages;
use Phptg\BotApi\Method\UnpinAllGeneralForumTopicMessages;
use Phptg\BotApi\Method\UnpinChatMessage;
use Phptg\BotApi\Method\Update\DeleteWebhook;
use Phptg\BotApi\Method\Update\GetUpdates;
use Phptg\BotApi\Method\Update\GetWebhookInfo;
use Phptg\BotApi\Method\Update\SetWebhook;
use Phptg\BotApi\Method\UpdatingMessage\DeleteBusinessMessages;
use Phptg\BotApi\Method\UpdatingMessage\DeleteMessage;
use Phptg\BotApi\Method\UpdatingMessage\DeleteMessages;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageCaption;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageLiveLocation;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageMedia;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageReplyMarkup;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageText;
use Phptg\BotApi\Method\UpdatingMessage\ReadBusinessMessage;
use Phptg\BotApi\Method\UpdatingMessage\StopMessageLiveLocation;
use Phptg\BotApi\Method\UpdatingMessage\StopPoll;
use Phptg\BotApi\Method\UpgradeGift;
use Phptg\BotApi\Method\VerifyChat;
use Phptg\BotApi\Method\VerifyUser;
use Phptg\BotApi\Method\EditMessageChecklist;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Transport\DownloadFileException;
use Phptg\BotApi\Transport\NativeTransport;
use Phptg\BotApi\Transport\TransportInterface;
use Phptg\BotApi\Type\AcceptedGiftTypes;
use Phptg\BotApi\Type\BotCommand;
use Phptg\BotApi\Type\BotCommandScope;
use Phptg\BotApi\Type\BotDescription;
use Phptg\BotApi\Type\BotName;
use Phptg\BotApi\Type\BotShortDescription;
use Phptg\BotApi\Type\BusinessConnection;
use Phptg\BotApi\Type\ChatAdministratorRights;
use Phptg\BotApi\Type\ChatFullInfo;
use Phptg\BotApi\Type\ChatInviteLink;
use Phptg\BotApi\Type\ChatMember;
use Phptg\BotApi\Type\ChatPermissions;
use Phptg\BotApi\Type\File;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\ForumTopic;
use Phptg\BotApi\Type\Game\GameHighScore;
use Phptg\BotApi\Type\Inline\InlineQueryResult;
use Phptg\BotApi\Type\Inline\InlineQueryResultsButton;
use Phptg\BotApi\Type\Inline\PreparedInlineMessage;
use Phptg\BotApi\Type\Inline\SentWebAppMessage;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputChecklist;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMedia;
use Phptg\BotApi\Type\InputMediaAudio;
use Phptg\BotApi\Type\InputMediaDocument;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputMediaVideo;
use Phptg\BotApi\Type\InputPaidMedia;
use Phptg\BotApi\Type\InputPollOption;
use Phptg\BotApi\Type\InputProfilePhoto;
use Phptg\BotApi\Type\InputStoryContent;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\MenuButton;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\MessageId;
use Phptg\BotApi\Type\OwnedGifts;
use Phptg\BotApi\Type\Passport\PassportElementError;
use Phptg\BotApi\Type\Payment\LabeledPrice;
use Phptg\BotApi\Type\Payment\ShippingOption;
use Phptg\BotApi\Type\Payment\StarTransactions;
use Phptg\BotApi\Type\Poll;
use Phptg\BotApi\Type\ReactionType;
use Phptg\BotApi\Type\ReplyKeyboardMarkup;
use Phptg\BotApi\Type\ReplyKeyboardRemove;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\StarAmount;
use Phptg\BotApi\Type\Sticker\Gifts;
use Phptg\BotApi\Type\Sticker\InputSticker;
use Phptg\BotApi\Type\Sticker\MaskPosition;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\Sticker\StickerSet;
use Phptg\BotApi\Type\Story;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\StoryArea;
use Phptg\BotApi\Type\Update\Update;
use Phptg\BotApi\Type\Update\WebhookInfo;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\UserChatBoosts;
use Phptg\BotApi\Type\UserProfileAudios;
use Phptg\BotApi\Type\UserProfilePhotos;

use function extension_loaded;
use function ini_get;

/**
 * @api
 */
final class TelegramBotApi
{
    private readonly Api $api;
    private readonly TransportInterface $transport;

    public function __construct(
        #[SensitiveParameter]
        private readonly string $token,
        private readonly string $baseUrl = 'https://api.telegram.org',
        ?TransportInterface $transport = null,
        private ?LoggerInterface $logger = null,
    ) {
        $this->transport = $transport ?? $this->createDefaultTransport();
        $this->api = new Api($token, $baseUrl, $this->transport);
    }

    public function withLogger(?LoggerInterface $logger): self
    {
        $new = clone $this;
        $new->logger = $logger;
        return $new;
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     *
     * @psalm-template TValue
     * @psalm-param MethodInterface<TValue> $method
     * @psalm-return TValue|FailResult
     */
    public function call(MethodInterface $method): mixed
    {
        return $this->api->call($method, $this->logger);
    }

    /**
     * Make a file URL on Telegram servers.
     *
     * @see https://core.telegram.org/bots/api#file
     * @see https://core.telegram.org/bots/api#getfile
     *
     * @param string|File $file File path or {@see File} object.
     *
     * @return string The file URL.
     *
     * @throws LogicException If the file path is not specified in `File` object.
     */
    public function makeFileUrl(string|File $file): string
    {
        if ($file instanceof File) {
            $path = $file->filePath;
            if ($path === null) {
                throw new LogicException('The file path is not specified.');
            }
        } else {
            $path = $file;
        }

        return $this->baseUrl . '/file/bot' . $this->token . '/' . $path;
    }

    /**
     * Downloads a file from the Telegram servers.
     *
     * @param string|File $file File path or {@see File} object.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     */
    public function downloadFile(string|File $file): DownloadedFile
    {
        /**
         * @var resource $stream `php://temp` always opens successfully.
         */
        $stream = fopen('php://temp', 'r+b');
        $this->transport->downloadFile(
            $this->makeFileUrl($file),
            $stream,
        );
        rewind($stream);
        return new DownloadedFile($stream);
    }

    /**
     * @see https://core.telegram.org/bots/api#addstickertoset
     */
    public function addStickerToSet(int $userId, string $name, InputSticker $sticker): FailResult|true
    {
        return $this->call(
            new AddStickerToSet($userId, $name, $sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answercallbackquery
     */
    public function answerCallbackQuery(
        string $callbackQueryId,
        ?string $text = null,
        ?bool $showAlert = null,
        ?string $url = null,
        ?int $cacheTime = null,
    ): FailResult|true {
        return $this->call(
            new AnswerCallbackQuery($callbackQueryId, $text, $showAlert, $url, $cacheTime),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param InlineQueryResult[] $results
     */
    public function answerInlineQuery(
        string $inlineQueryId,
        array $results,
        ?int $cacheTime = null,
        ?bool $isPersonal = null,
        ?string $nextOffset = null,
        ?InlineQueryResultsButton $button = null,
    ): FailResult|true {
        return $this->call(
            new AnswerInlineQuery($inlineQueryId, $results, $cacheTime, $isPersonal, $nextOffset, $button),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     */
    public function answerPreCheckoutQuery(
        string $preCheckoutQueryId,
        bool $ok,
        ?string $errorMessage = null,
    ): FailResult|true {
        return $this->call(
            new AnswerPreCheckoutQuery($preCheckoutQueryId, $ok, $errorMessage),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answershippingquery
     *
     * @param ShippingOption[]|null $shippingOptions
     */
    public function answerShippingQuery(
        string $shippingQueryId,
        bool $ok,
        ?array $shippingOptions = null,
        ?string $errorMessage = null,
    ): FailResult|true {
        return $this->call(
            new AnswerShippingQuery($shippingQueryId, $ok, $shippingOptions, $errorMessage),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#answerwebappquery
     */
    public function answerWebAppQuery(string $webAppQueryId, InlineQueryResult $result): FailResult|SentWebAppMessage
    {
        return $this->call(
            new AnswerWebAppQuery($webAppQueryId, $result),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     */
    public function approveChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->call(
            new ApproveChatJoinRequest($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#approvesuggestedpost
     */
    public function approveSuggestedPost(int $chatId, int $messageId, ?int $sendDate = null): FailResult|true
    {
        return $this->call(
            new ApproveSuggestedPost($chatId, $messageId, $sendDate),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatmember
     */
    public function banChatMember(
        int|string $chatId,
        int $userId,
        ?DateTimeInterface $untilDate = null,
        ?bool $revokeMessages = null,
    ): FailResult|true {
        return $this->call(
            new BanChatMember($chatId, $userId, $untilDate, $revokeMessages),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     */
    public function banChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->call(
            new BanChatSenderChat($chatId, $senderChatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#close
     */
    public function close(): FailResult|true
    {
        return $this->call(new Close());
    }

    /**
     * @see https://core.telegram.org/bots/api#closeforumtopic
     */
    public function closeForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->call(new CloseForumTopic($chatId, $messageThreadId));
    }

    /**
     * @see https://core.telegram.org/bots/api#closegeneralforumtopic
     */
    public function closeGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->call(new CloseGeneralForumTopic($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#convertgifttostars
     */
    public function convertGiftToStars(
        string $businessConnectionId,
        string $ownedGiftId,
    ): FailResult|true {
        return $this->call(
            new ConvertGiftToStars($businessConnectionId, $ownedGiftId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessage
     *
     * @param MessageEntity[]|null $captionEntities
     */
    public function copyMessage(
        int|string $chatId,
        int|string $fromChatId,
        int $messageId,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $videoStartTimestamp = null,
        ?int $directMessagesTopicId = null,
        ?string $messageEffectId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|MessageId {
        return $this->call(
            new CopyMessage(
                $chatId,
                $fromChatId,
                $messageId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $disableNotification,
                $protectContent,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $videoStartTimestamp,
                $directMessagesTopicId,
                $messageEffectId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#copymessages
     *
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
     */
    public function copyMessages(
        int|string $chatId,
        int|string $fromChatId,
        array $messageIds,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?bool $removeCaption = null,
        ?int $directMessagesTopicId = null,
    ): FailResult|array {
        return $this->call(
            new CopyMessages(
                $chatId,
                $fromChatId,
                $messageIds,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $removeCaption,
                $directMessagesTopicId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     */
    public function createChatInviteLink(
        int|string $chatId,
        ?string $name = null,
        ?DateTimeImmutable $expireDate = null,
        ?int $memberLimit = null,
        ?bool $createsJoinRequest = null,
    ): FailResult|ChatInviteLink {
        return $this->call(
            new CreateChatInviteLink($chatId, $name, $expireDate, $memberLimit, $createsJoinRequest),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
     */
    public function createChatSubscriptionInviteLink(
        int|string $chatId,
        int $subscriptionPeriod,
        int $subscriptionPrice,
        ?string $name = null,
    ): FailResult|ChatInviteLink {
        return $this->call(
            new CreateChatSubscriptionInviteLink($chatId, $subscriptionPeriod, $subscriptionPrice, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createforumtopic
     */
    public function createForumTopic(
        int|string $chatId,
        string $name,
        ?int $iconColor = null,
        ?string $iconCustomEmojiId = null,
    ): FailResult|ForumTopic {
        return $this->call(
            new CreateForumTopic($chatId, $name, $iconColor, $iconCustomEmojiId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createinvoicelink
     *
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function createInvoiceLink(
        string $title,
        string $description,
        string $payload,
        string $currency,
        array $prices,
        #[SensitiveParameter]
        ?string $providerToken = null,
        ?int $maxTipAmount = null,
        ?array $suggestedTipAmounts = null,
        ?string $providerData = null,
        ?string $photoUrl = null,
        ?int $photoSize = null,
        ?int $photoWidth = null,
        ?int $photoHeight = null,
        ?bool $needName = null,
        ?bool $needPhoneNumber = null,
        ?bool $needEmail = null,
        ?bool $needShippingAddress = null,
        ?bool $sendPhoneNumberToProvider = null,
        ?bool $sendEmailToProvider = null,
        ?bool $isFlexible = null,
        ?int $subscriptionPeriod = null,
        ?string $businessConnectionId = null,
    ): FailResult|string {
        return $this->call(
            new CreateInvoiceLink(
                $title,
                $description,
                $payload,
                $currency,
                $prices,
                $providerToken,
                $maxTipAmount,
                $suggestedTipAmounts,
                $providerData,
                $photoUrl,
                $photoSize,
                $photoWidth,
                $photoHeight,
                $needName,
                $needPhoneNumber,
                $needEmail,
                $needShippingAddress,
                $sendPhoneNumberToProvider,
                $sendEmailToProvider,
                $isFlexible,
                $subscriptionPeriod,
                $businessConnectionId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param InputSticker[] $stickers
     */
    public function createNewStickerSet(
        int $userId,
        string $name,
        string $title,
        array $stickers,
        ?string $stickerType = null,
        ?bool $needsRepainting = null,
    ): FailResult|true {
        return $this->call(
            new CreateNewStickerSet($userId, $name, $title, $stickers, $stickerType, $needsRepainting),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#declinechatjoinrequest
     */
    public function declineChatJoinRequest(int|string $chatId, int $userId): FailResult|true
    {
        return $this->call(
            new DeclineChatJoinRequest($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#declinesuggestedpost
     */
    public function declineSuggestedPost(int $chatId, int $messageId, ?string $comment = null): FailResult|true
    {
        return $this->call(
            new DeclineSuggestedPost($chatId, $messageId, $comment),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletebusinessmessages
     *
     * @param int[] $messageIds
     */
    public function deleteBusinessMessages(
        string $businessConnectionId,
        array $messageIds,
    ): FailResult|true {
        return $this->call(
            new DeleteBusinessMessages($businessConnectionId, $messageIds),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletechatphoto
     */
    public function deleteChatPhoto(int|string $chatId): FailResult|true
    {
        return $this->call(
            new DeleteChatPhoto($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletechatstickerset
     */
    public function deleteChatStickerSet(int|string $chatId): FailResult|true
    {
        return $this->call(
            new DeleteChatStickerSet($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deleteforumtopic
     */
    public function deleteForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->call(new DeleteForumTopic($chatId, $messageThreadId));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemessage
     */
    public function deleteMessage(int|string $chatId, int $messageId): FailResult|true
    {
        return $this->call(new DeleteMessage($chatId, $messageId));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemessages
     *
     * @param int[] $messageIds
     */
    public function deleteMessages(int|string $chatId, array $messageIds): FailResult|true
    {
        return $this->call(new DeleteMessages($chatId, $messageIds));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemycommands
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|true
    {
        return $this->call(new DeleteMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     */
    public function deleteStickerFromSet(string $sticker): FailResult|true
    {
        return $this->call(
            new DeleteStickerFromSet($sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletestickerset
     */
    public function deleteStickerSet(string $name): FailResult|true
    {
        return $this->call(new DeleteStickerSet($name));
    }

    /**
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     */
    public function editChatInviteLink(
        int|string $chatId,
        string $inviteLink,
        ?string $name = null,
        ?DateTimeImmutable $expireDate = null,
        ?int $memberLimit = null,
        ?bool $createsJoinRequest = null,
    ): FailResult|ChatInviteLink {
        return $this->call(
            new EditChatInviteLink($chatId, $inviteLink, $name, $expireDate, $memberLimit, $createsJoinRequest),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink
     */
    public function editChatSubscriptionInviteLink(
        int|string $chatId,
        string $inviteLink,
        ?string $name = null,
    ): FailResult|ChatInviteLink {
        return $this->call(
            new EditChatSubscriptionInviteLink($chatId, $inviteLink, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editforumtopic
     */
    public function editForumTopic(
        int|string $chatId,
        int $messageThreadId,
        ?string $name = null,
        ?string $iconCustomEmojiId = null,
    ): FailResult|true {
        return $this->call(
            new EditForumTopic($chatId, $messageThreadId, $name, $iconCustomEmojiId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editgeneralforumtopic
     */
    public function editGeneralForumTopic(int|string $chatId, string $name): FailResult|true
    {
        return $this->call(
            new EditGeneralForumTopic($chatId, $name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param MessageEntity[]|null $captionEntities
     */
    public function editMessageCaption(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new EditMessageCaption(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     */
    public function editMessageLiveLocation(
        float $latitude,
        float $longitude,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?int $livePeriod = null,
        ?float $horizontalAccuracy = null,
        ?int $heading = null,
        ?int $proximityAlertRadius = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new EditMessageLiveLocation(
                $latitude,
                $longitude,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $livePeriod,
                $horizontalAccuracy,
                $heading,
                $proximityAlertRadius,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagemedia
     */
    public function editMessageMedia(
        InputMedia $media,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new EditMessageMedia(
                $media,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagechecklist
     */
    public function editMessageChecklist(
        string $businessConnectionId,
        int $chatId,
        int $messageId,
        InputChecklist $checklist,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message {
        return $this->call(
            new EditMessageChecklist(
                $businessConnectionId,
                $chatId,
                $messageId,
                $checklist,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     */
    public function editMessageReplyMarkup(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new EditMessageReplyMarkup(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagetext
     *
     * @param MessageEntity[]|null $entities
     */
    public function editMessageText(
        string $text,
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?string $parseMode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $linkPreviewOptions = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new EditMessageText(
                $text,
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $parseMode,
                $entities,
                $linkPreviewOptions,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#editstory
     *
     * @param MessageEntity[]|null $captionEntities
     * @param StoryArea[]|null $areas
     */
    public function editStory(
        string $businessConnectionId,
        int $storyId,
        InputStoryContent $content,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?array $areas = null,
    ): FailResult|Story {
        return $this->call(
            new EditStory(
                $businessConnectionId,
                $storyId,
                $content,
                $caption,
                $parseMode,
                $captionEntities,
                $areas,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#edituserstarsubscription
     */
    public function editUserStarSubscription(
        int $userId,
        string $telegramPaymentChargeId,
        bool $isCanceled,
    ): FailResult|true {
        return $this->call(
            new EditUserStarSubscription(
                $userId,
                $telegramPaymentChargeId,
                $isCanceled,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     */
    public function exportChatInviteLink(int|string $chatId): FailResult|string
    {
        return $this->call(
            new ExportChatInviteLink($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#forwardmessage
     */
    public function forwardMessage(
        int|string $chatId,
        int|string $fromChatId,
        int $messageId,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?int $videoStartTimestamp = null,
        ?int $directMessagesTopicId = null,
        ?string $messageEffectId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new ForwardMessage(
                $chatId,
                $fromChatId,
                $messageId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $videoStartTimestamp,
                $directMessagesTopicId,
                $messageEffectId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param int[] $messageIds
     * @return FailResult|MessageId[]
     *
     * @see https://core.telegram.org/bots/api#forwardmessages
     */
    public function forwardMessages(
        int|string $chatId,
        int|string $fromChatId,
        array $messageIds,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?int $directMessagesTopicId = null,
    ): FailResult|array {
        return $this->call(
            new ForwardMessages(
                $chatId,
                $fromChatId,
                $messageIds,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $directMessagesTopicId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletestory
     */
    public function deleteStory(string $businessConnectionId, int $storyId): FailResult|true
    {
        return $this->call(
            new DeleteStory($businessConnectionId, $storyId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#deletewebhook
     */
    public function deleteWebhook(?bool $dropPendingUpdates = null): FailResult|true
    {
        return $this->call(new DeleteWebhook($dropPendingUpdates));
    }

    /**
     * @see https://core.telegram.org/bots/api#getavailablegifts
     */
    public function getAvailableGifts(): FailResult|Gifts
    {
        return $this->call(new GetAvailableGifts());
    }

    /**
     * @see https://core.telegram.org/bots/api#getbusinessaccountgifts
     */
    public function getBusinessAccountGifts(
        string $businessConnectionId,
        ?bool $excludeUnsaved = null,
        ?bool $excludeSaved = null,
        ?bool $excludeUnlimited = null,
        ?bool $excludeLimitedUpgradable = null,
        ?bool $excludeLimitedNonUpgradable = null,
        ?bool $excludeUnique = null,
        ?bool $excludeFromBlockchain = null,
        ?bool $sortByPrice = null,
        ?string $offset = null,
        ?int $limit = null,
    ): FailResult|OwnedGifts {
        return $this->call(
            new GetBusinessAccountGifts(
                $businessConnectionId,
                $excludeUnsaved,
                $excludeSaved,
                $excludeUnlimited,
                $excludeLimitedUpgradable,
                $excludeLimitedNonUpgradable,
                $excludeUnique,
                $excludeFromBlockchain,
                $sortByPrice,
                $offset,
                $limit,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getbusinessaccountstarbalance
     */
    public function getBusinessAccountStarBalance(string $businessConnectionId): FailResult|StarAmount
    {
        return $this->call(
            new GetBusinessAccountStarBalance($businessConnectionId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getbusinessconnection
     */
    public function getBusinessConnection(string $businessConnectionId): FailResult|BusinessConnection
    {
        return $this->call(new GetBusinessConnection($businessConnectionId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     */
    public function getChat(int|string $chatId): FailResult|ChatFullInfo
    {
        return $this->call(new GetChat($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatgifts
     */
    public function getChatGifts(
        int|string $chatId,
        ?bool $excludeUnsaved = null,
        ?bool $excludeSaved = null,
        ?bool $excludeUnlimited = null,
        ?bool $excludeLimitedUpgradable = null,
        ?bool $excludeLimitedNonUpgradable = null,
        ?bool $excludeFromBlockchain = null,
        ?bool $excludeUnique = null,
        ?bool $sortByPrice = null,
        ?string $offset = null,
        ?int $limit = null,
    ): FailResult|OwnedGifts {
        return $this->call(
            new GetChatGifts(
                $chatId,
                $excludeUnsaved,
                $excludeSaved,
                $excludeUnlimited,
                $excludeLimitedUpgradable,
                $excludeLimitedNonUpgradable,
                $excludeFromBlockchain,
                $excludeUnique,
                $sortByPrice,
                $offset,
                $limit,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatadministrators
     *
     * @return FailResult|ChatMember[]
     */
    public function getChatAdministrators(int|string $chatId): FailResult|array
    {
        return $this->call(new GetChatAdministrators($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmembercount
     */
    public function getChatMemberCount(int|string $chatId): FailResult|int
    {
        return $this->call(new GetChatMemberCount($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmember
     */
    public function getChatMember(int|string $chatId, int $userId): FailResult|ChatMember
    {
        return $this->call(new GetChatMember($chatId, $userId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchatmenubutton
     */
    public function getChatMenuButton(?int $chatId = null): FailResult|MenuButton
    {
        return $this->call(new GetChatMenuButton($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getcustomemojistickers
     *
     * @param string[] $customEmojiIds
     * @return FailResult|Sticker[]
     */
    public function getCustomEmojiStickers(array $customEmojiIds): FailResult|array
    {
        return $this->call(new GetCustomEmojiStickers($customEmojiIds));
    }

    /**
     * @see https://core.telegram.org/bots/api#getfile
     */
    public function getFile(string $fileId): FailResult|File
    {
        return $this->call(new GetFile($fileId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
     *
     * @return FailResult|Sticker[]
     */
    public function getForumTopicIconStickers(): FailResult|array
    {
        return $this->call(new GetForumTopicIconStickers());
    }

    /**
     * @see https://core.telegram.org/bots/api#getgamehighscores
     *
     * @return FailResult|GameHighScore[]
     */
    public function getGameHighScores(
        int $userId,
        ?int $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
    ): FailResult|array {
        return $this->call(
            new GetGameHighScores($userId, $chatId, $messageId, $inlineMessageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     */
    public function getMe(): FailResult|User
    {
        return $this->call(new GetMe());
    }

    /**
     * @see https://core.telegram.org/bots/api#getmycommands
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|array
    {
        return $this->call(new GetMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
     */
    public function getMyDefaultAdministratorRights(?bool $forChannels = null): FailResult|ChatAdministratorRights
    {
        return $this->call(new GetMyDefaultAdministratorRights($forChannels));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydescription
     */
    public function getMyDescription(?string $languageCode = null): FailResult|BotDescription
    {
        return $this->call(new GetMyDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyname
     */
    public function getMyName(?string $languageCode = null): FailResult|BotName
    {
        return $this->call(new GetMyName($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyshortdescription
     */
    public function getMyShortDescription(?string $languageCode = null): FailResult|BotShortDescription
    {
        return $this->call(new GetMyShortDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmystarbalance
     */
    public function getMyStarBalance(): FailResult|StarAmount
    {
        return $this->call(new GetMyStarBalance());
    }

    /**
     * @see https://core.telegram.org/bots/api#getstartransactions
     */
    public function getStarTransactions(?int $offset = null, ?int $limit = null): FailResult|StarTransactions
    {
        return $this->call(
            new GetStarTransactions($offset, $limit),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getstickerset
     */
    public function getStickerSet(string $name): FailResult|StickerSet
    {
        return $this->call(
            new GetStickerSet($name),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getupdates
     *
     * @param string[]|null $allowedUpdates
     * @return FailResult|Update[]
     */
    public function getUpdates(
        ?int $offset = null,
        ?int $limit = null,
        ?int $timeout = null,
        ?array $allowedUpdates = null,
    ): FailResult|array {
        return $this->call(new GetUpdates($offset, $limit, $timeout, $allowedUpdates));
    }

    /**
     * @see https://core.telegram.org/bots/api#getuserchatboosts
     */
    public function getUserChatBoosts(int|string $chatId, int $userId): FailResult|UserChatBoosts
    {
        return $this->call(
            new GetUserChatBoosts($chatId, $userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getusergifts
     */
    public function getUserGifts(
        int $userId,
        ?bool $excludeUnlimited = null,
        ?bool $excludeLimitedUpgradable = null,
        ?bool $excludeLimitedNonUpgradable = null,
        ?bool $excludeFromBlockchain = null,
        ?bool $excludeUnique = null,
        ?bool $sortByPrice = null,
        ?string $offset = null,
        ?int $limit = null,
    ): FailResult|OwnedGifts {
        return $this->call(
            new GetUserGifts(
                $userId,
                $excludeUnlimited,
                $excludeLimitedUpgradable,
                $excludeLimitedNonUpgradable,
                $excludeFromBlockchain,
                $excludeUnique,
                $sortByPrice,
                $offset,
                $limit,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getuserprofileaudios
     */
    public function getUserProfileAudios(
        int $userId,
        ?int $offset = null,
        ?int $limit = null,
    ): FailResult|UserProfileAudios {
        return $this->call(
            new GetUserProfileAudios($userId, $offset, $limit),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     */
    public function getUserProfilePhotos(
        int $userId,
        ?int $offset = null,
        ?int $limit = null,
    ): FailResult|UserProfilePhotos {
        return $this->call(
            new GetUserProfilePhotos($userId, $offset, $limit),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#getwebhookinfo
     */
    public function getWebhookInfo(): FailResult|WebhookInfo
    {
        return $this->call(new GetWebhookInfo());
    }

    /**
     * @see https://core.telegram.org/bots/api#giftpremiumsubscription
     *
     * @param MessageEntity[]|null $textEntities
     */
    public function giftPremiumSubscription(
        int $userId,
        int $monthCount,
        int $starCount,
        ?string $text = null,
        ?string $textParseMode = null,
        ?array $textEntities = null,
    ): FailResult|true {
        return $this->call(
            new GiftPremiumSubscription(
                $userId,
                $monthCount,
                $starCount,
                $text,
                $textParseMode,
                $textEntities,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#hidegeneralforumtopic
     */
    public function hideGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->call(
            new HideGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#leavechat
     */
    public function leaveChat(int|string $chatId): FailResult|true
    {
        return $this->call(
            new LeaveChat($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#logout
     */
    public function logOut(): FailResult|true
    {
        return $this->call(new LogOut());
    }

    /**
     * @see https://core.telegram.org/bots/api#pinchatmessage
     */
    public function pinChatMessage(
        int|string $chatId,
        int $messageId,
        ?bool $disableNotification = null,
    ): FailResult|true {
        return $this->call(
            new PinChatMessage($chatId, $messageId, $disableNotification),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#poststory
     *
     * @param MessageEntity[]|null $captionEntities
     * @param StoryArea[]|null $areas
     */
    public function postStory(
        string $businessConnectionId,
        InputStoryContent $content,
        int $activePeriod,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?array $areas = null,
        ?bool $postToChatPage = null,
        ?bool $protectContent = null,
    ): FailResult|Story {
        return $this->call(
            new PostStory(
                $businessConnectionId,
                $content,
                $activePeriod,
                $caption,
                $parseMode,
                $captionEntities,
                $areas,
                $postToChatPage,
                $protectContent,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#repoststory
     */
    public function repostStory(
        string $businessConnectionId,
        int $fromChatId,
        int $fromStoryId,
        int $activePeriod,
        ?bool $postToChatPage = null,
        ?bool $protectContent = null,
    ): FailResult|Story {
        return $this->call(
            new RepostStory(
                $businessConnectionId,
                $fromChatId,
                $fromStoryId,
                $activePeriod,
                $postToChatPage,
                $protectContent,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#promotechatmember
     */
    public function promoteChatMember(
        int|string $chatId,
        int $userId,
        ?bool $isAnonymous = null,
        ?bool $canManageChat = null,
        ?bool $canDeleteMessages = null,
        ?bool $canManageVideoChats = null,
        ?bool $canRestrictMembers = null,
        ?bool $canPromoteMembers = null,
        ?bool $canChangeInfo = null,
        ?bool $canInviteUsers = null,
        ?bool $canPostStories = null,
        ?bool $canEditStories = null,
        ?bool $canDeleteStories = null,
        ?bool $canPostMessages = null,
        ?bool $canEditMessages = null,
        ?bool $canPinMessages = null,
        ?bool $canManageTopics = null,
        ?bool $canManageDirectMessages = null,
    ): FailResult|true {
        return $this->call(
            new PromoteChatMember(
                $chatId,
                $userId,
                $isAnonymous,
                $canManageChat,
                $canDeleteMessages,
                $canManageVideoChats,
                $canRestrictMembers,
                $canPromoteMembers,
                $canChangeInfo,
                $canInviteUsers,
                $canPostStories,
                $canEditStories,
                $canDeleteStories,
                $canPostMessages,
                $canEditMessages,
                $canPinMessages,
                $canManageTopics,
                $canManageDirectMessages,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#readbusinessmessage
     */
    public function readBusinessMessage(
        string $businessConnectionId,
        int $chatId,
        int $messageId,
    ): FailResult|true {
        return $this->call(
            new ReadBusinessMessage($businessConnectionId, $chatId, $messageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#refundstarpayment
     */
    public function refundStarPayment(int $userId, string $telegramPaymentChargeId): FailResult|true
    {
        return $this->call(
            new RefundStarPayment($userId, $telegramPaymentChargeId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#removebusinessaccountprofilephoto
     */
    public function removeBusinessAccountProfilePhoto(
        string $businessConnectionId,
        ?bool $isPublic = null,
    ): FailResult|true {
        return $this->call(
            new RemoveBusinessAccountProfilePhoto($businessConnectionId, $isPublic),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#removemyprofilephoto
     */
    public function removeMyProfilePhoto(): FailResult|true
    {
        return $this->call(new RemoveMyProfilePhoto());
    }

    /**
     * @see https://core.telegram.org/bots/api#removechatverification
     */
    public function removeChatVerification(int|string $chatId): FailResult|true
    {
        return $this->call(
            new RemoveChatVerification($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#removeuserverification
     */
    public function removeUserVerification(int $userId): FailResult|true
    {
        return $this->call(
            new RemoveUserVerification($userId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#reopenforumtopic
     */
    public function reopenForumTopic(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->call(
            new ReopenForumTopic($chatId, $messageThreadId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#reopengeneralforumtopic
     */
    public function reopenGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->call(
            new ReopenGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#replacestickerinset
     */
    public function replaceStickerInSet(
        int $userId,
        string $name,
        string $oldSticker,
        InputSticker $sticker,
    ): FailResult|true {
        return $this->call(
            new ReplaceStickerInSet($userId, $name, $oldSticker, $sticker),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#restrictchatmember
     */
    public function restrictChatMember(
        int|string $chatId,
        int $userId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
        ?DateTimeImmutable $untilDate = null,
    ): FailResult|true {
        return $this->call(
            new RestrictChatMember($chatId, $userId, $permissions, $useIndependentChatPermissions, $untilDate),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     */
    public function revokeChatInviteLink(int|string $chatId, string $inviteLink): FailResult|ChatInviteLink
    {
        return $this->call(
            new RevokeChatInviteLink($chatId, $inviteLink),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#savepreparedinlinemessage
     */
    public function savePreparedInlineMessage(
        int $userId,
        InlineQueryResult $result,
        ?bool $allowUserChats = null,
        ?bool $allowBotChats = null,
        ?bool $allowGroupChats = null,
        ?bool $allowChannelChats = null,
    ): FailResult|PreparedInlineMessage {
        return $this->call(
            new SavePreparedInlineMessage(
                $userId,
                $result,
                $allowUserChats,
                $allowBotChats,
                $allowGroupChats,
                $allowChannelChats,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendanimation
     */
    public function sendAnimation(
        int|string $chatId,
        InputFile|string $animation,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        InputFile|string|null $thumbnail = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $hasSpoiler = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendAnimation(
                $chatId,
                $animation,
                $businessConnectionId,
                $messageThreadId,
                $duration,
                $width,
                $height,
                $thumbnail,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $hasSpoiler,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendaudio
     */
    public function sendAudio(
        int|string $chatId,
        string|InputFile $audio,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?int $duration = null,
        ?string $performer = null,
        ?string $title = null,
        string|InputFile|null $thumbnail = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendAudio(
                $chatId,
                $audio,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $duration,
                $performer,
                $title,
                $thumbnail,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendchataction
     */
    public function sendChatAction(
        int|string $chatId,
        string $action,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
    ): FailResult|true {
        return $this->call(
            new SendChatAction(
                $chatId,
                $action,
                $businessConnectionId,
                $messageThreadId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendcontact
     */
    public function sendContact(
        int|string $chatId,
        string $phoneNumber,
        string $firstName,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $lastName = null,
        ?string $vcard = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendContact(
                $chatId,
                $phoneNumber,
                $firstName,
                $businessConnectionId,
                $messageThreadId,
                $lastName,
                $vcard,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendchecklist
     */
    public function sendChecklist(
        string $businessConnectionId,
        int $chatId,
        InputChecklist $checklist,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message {
        return $this->call(
            new SendChecklist(
                $businessConnectionId,
                $chatId,
                $checklist,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#senddice
     */
    public function sendDice(
        int|string $chatId,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $emoji = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendDice(
                $chatId,
                $businessConnectionId,
                $messageThreadId,
                $emoji,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#senddocument
     */
    public function sendDocument(
        int|string $chatId,
        string|InputFile $document,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        string|InputFile|null $thumbnail = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $disableContentTypeDetection = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendDocument(
                $chatId,
                $document,
                $businessConnectionId,
                $messageThreadId,
                $thumbnail,
                $caption,
                $parseMode,
                $captionEntities,
                $disableContentTypeDetection,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendgame
     */
    public function sendGame(
        int $chatId,
        string $gameShortName,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
    ): FailResult|Message {
        return $this->call(
            new SendGame(
                $chatId,
                $gameShortName,
                $businessConnectionId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendgift
     *
     * @param MessageEntity[]|null $textEntities
     */
    public function sendGift(
        int $userId,
        string $giftId,
        ?string $text = null,
        ?string $textParseMode = null,
        ?array $textEntities = null,
        ?bool $payForUpgrade = null,
        int|string|null $chatId = null,
    ): FailResult|true {
        return $this->call(
            new SendGift(
                $userId,
                $giftId,
                $text,
                $textParseMode,
                $textEntities,
                $payForUpgrade,
                $chatId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendinvoice
     *
     * @param LabeledPrice[] $prices
     * @param int[]|null $suggestedTipAmounts
     */
    public function sendInvoice(
        int|string $chatId,
        string $title,
        string $description,
        string $payload,
        string $currency,
        array $prices,
        ?int $messageThreadId = null,
        #[SensitiveParameter]
        ?string $providerToken = null,
        ?int $maxTipAmount = null,
        ?array $suggestedTipAmounts = null,
        ?string $startParameter = null,
        ?string $providerData = null,
        ?string $photoUrl = null,
        ?int $photoSize = null,
        ?int $photoWidth = null,
        ?int $photoHeight = null,
        ?bool $needName = null,
        ?bool $needPhoneNumber = null,
        ?bool $needEmail = null,
        ?bool $needShippingAddress = null,
        ?bool $sendPhoneNumberToProvider = null,
        ?bool $sendEmailToProvider = null,
        ?bool $isFlexible = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendInvoice(
                $chatId,
                $title,
                $description,
                $payload,
                $currency,
                $prices,
                $messageThreadId,
                $providerToken,
                $maxTipAmount,
                $suggestedTipAmounts,
                $startParameter,
                $providerData,
                $photoUrl,
                $photoSize,
                $photoWidth,
                $photoHeight,
                $needName,
                $needPhoneNumber,
                $needEmail,
                $needShippingAddress,
                $sendPhoneNumberToProvider,
                $sendEmailToProvider,
                $isFlexible,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendlocation
     */
    public function sendLocation(
        int|string $chatId,
        float $latitude,
        float $longitude,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?float $horizontalAccuracy = null,
        ?int $livePeriod = null,
        ?int $heading = null,
        ?int $proximityAlertRadius = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendLocation(
                $chatId,
                $latitude,
                $longitude,
                $businessConnectionId,
                $messageThreadId,
                $horizontalAccuracy,
                $livePeriod,
                $heading,
                $proximityAlertRadius,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media
     * @return FailResult|Message[]
     */
    public function sendMediaGroup(
        int|string $chatId,
        array $media,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
    ): FailResult|array {
        return $this->call(
            new SendMediaGroup(
                $chatId,
                $media,
                $businessConnectionId,
                $messageThreadId,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $allowPaidBroadcast,
                $directMessagesTopicId,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $entities
     *
     * @see https://core.telegram.org/bots/api#sendmessage
     */
    public function sendMessage(
        int|string $chatId,
        string $text,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $parseMode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $linkPreviewOptions = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendMessage(
                $chatId,
                $text,
                $businessConnectionId,
                $messageThreadId,
                $parseMode,
                $entities,
                $linkPreviewOptions,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessagedraft
     *
     * @param MessageEntity[]|null $entities
     */
    public function sendMessageDraft(
        int $chatId,
        int $draftId,
        string $text,
        ?int $messageThreadId = null,
        ?string $parseMode = null,
        ?array $entities = null,
    ): FailResult|true {
        return $this->call(
            new SendMessageDraft(
                $chatId,
                $draftId,
                $text,
                $messageThreadId,
                $parseMode,
                $entities,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendpaidmedia
     *
     * @param InputPaidMedia[] $media
     * @param MessageEntity[]|null $captionEntities
     */
    public function sendPaidMedia(
        int|string $chatId,
        int $starCount,
        array $media,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?string $businessConnectionId = null,
        ?string $payload = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
        ?int $messageThreadId = null,
    ): FailResult|Message {
        return $this->call(
            new SendPaidMedia(
                $chatId,
                $starCount,
                $media,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $disableNotification,
                $protectContent,
                $replyParameters,
                $replyMarkup,
                $businessConnectionId,
                $payload,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
                $messageThreadId,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendphoto
     */
    public function sendPhoto(
        int|string $chatId,
        string|InputFile $photo,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $hasSpoiler = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendPhoto(
                $chatId,
                $photo,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $hasSpoiler,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param InputPollOption[] $options
     * @param MessageEntity[]|null $questionEntities
     * @param MessageEntity[]|null $explanationEntities
     *
     * @see https://core.telegram.org/bots/api#sendpoll
     */
    public function sendPoll(
        int|string $chatId,
        string $question,
        array $options,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $questionParseMode = null,
        ?array $questionEntities = null,
        ?bool $isAnonymous = null,
        ?string $type = null,
        ?bool $allowsMultipleAnswers = null,
        ?int $correctOptionId = null,
        ?string $explanation = null,
        ?string $explanationParseMode = null,
        ?array $explanationEntities = null,
        ?int $openPeriod = null,
        ?DateTimeImmutable $closeDate = null,
        ?bool $isClosed = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
    ): FailResult|Message {
        return $this->call(
            new SendPoll(
                $chatId,
                $question,
                $options,
                $businessConnectionId,
                $messageThreadId,
                $questionParseMode,
                $questionEntities,
                $isAnonymous,
                $type,
                $allowsMultipleAnswers,
                $correctOptionId,
                $explanation,
                $explanationParseMode,
                $explanationEntities,
                $openPeriod,
                $closeDate,
                $isClosed,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendsticker
     */
    public function sendSticker(
        int|string $chatId,
        InputFile|string $sticker,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $emoji = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendSticker(
                $chatId,
                $sticker,
                $businessConnectionId,
                $messageThreadId,
                $emoji,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendvenue
     */
    public function sendVenue(
        int|string $chatId,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $foursquareId = null,
        ?string $foursquareType = null,
        ?string $googlePlaceId = null,
        ?string $googlePlaceType = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendVenue(
                $chatId,
                $latitude,
                $longitude,
                $title,
                $address,
                $businessConnectionId,
                $messageThreadId,
                $foursquareId,
                $foursquareType,
                $googlePlaceId,
                $googlePlaceType,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvideo
     */
    public function sendVideo(
        int|string $chatId,
        string|InputFile $video,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        string|InputFile|null $thumbnail = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?bool $showCaptionAboveMedia = null,
        ?bool $hasSpoiler = null,
        ?bool $supportsStreaming = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        string|InputFile|null $cover = null,
        ?int $startTimestamp = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendVideo(
                $chatId,
                $video,
                $businessConnectionId,
                $messageThreadId,
                $duration,
                $width,
                $height,
                $thumbnail,
                $caption,
                $parseMode,
                $captionEntities,
                $showCaptionAboveMedia,
                $hasSpoiler,
                $supportsStreaming,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $cover,
                $startTimestamp,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#sendvideonote
     */
    public function sendVideoNote(
        int|string $chatId,
        string|InputFile $videoNote,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?int $duration = null,
        ?int $length = null,
        string|InputFile|null $thumbnail = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendVideoNote(
                $chatId,
                $videoNote,
                $businessConnectionId,
                $messageThreadId,
                $duration,
                $length,
                $thumbnail,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @param MessageEntity[]|null $captionEntities
     *
     * @see https://core.telegram.org/bots/api#sendvoice
     */
    public function sendVoice(
        int|string $chatId,
        string|InputFile $voice,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $caption = null,
        ?string $parseMode = null,
        ?array $captionEntities = null,
        ?int $duration = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        ?bool $allowPaidBroadcast = null,
        ?int $directMessagesTopicId = null,
        ?SuggestedPostParameters $suggestedPostParameters = null,
    ): FailResult|Message {
        return $this->call(
            new SendVoice(
                $chatId,
                $voice,
                $businessConnectionId,
                $messageThreadId,
                $caption,
                $parseMode,
                $captionEntities,
                $duration,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
                $allowPaidBroadcast,
                $directMessagesTopicId,
                $suggestedPostParameters,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setbusinessaccountbio
     */
    public function setBusinessAccountBio(string $businessConnectionId, ?string $bio = null): FailResult|true
    {
        return $this->call(
            new SetBusinessAccountBio($businessConnectionId, $bio),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setbusinessaccountgiftsettings
     */
    public function setBusinessAccountGiftSettings(
        string $businessConnectionId,
        bool $showGiftButton,
        AcceptedGiftTypes $acceptedGiftTypes,
    ): FailResult|true {
        return $this->call(
            new SetBusinessAccountGiftSettings(
                $businessConnectionId,
                $showGiftButton,
                $acceptedGiftTypes,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setbusinessaccountname
     */
    public function setBusinessAccountName(
        string $businessConnectionId,
        string $firstName,
        ?string $lastName = null,
    ): FailResult|true {
        return $this->call(
            new SetBusinessAccountName($businessConnectionId, $firstName, $lastName),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setbusinessaccountprofilephoto
     */
    public function setBusinessAccountProfilePhoto(
        string $businessConnectionId,
        InputProfilePhoto $photo,
        ?bool $isPublic = null,
    ): FailResult|true {
        return $this->call(
            new SetBusinessAccountProfilePhoto($businessConnectionId, $photo, $isPublic),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setbusinessaccountusername
     */
    public function setBusinessAccountUsername(string $businessConnectionId, ?string $username = null): FailResult|true
    {
        return $this->call(
            new SetBusinessAccountUsername($businessConnectionId, $username),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     */
    public function setChatAdministratorCustomTitle(
        int|string $chatId,
        int $userId,
        string $customTitle,
    ): FailResult|true {
        return $this->call(
            new SetChatAdministratorCustomTitle($chatId, $userId, $customTitle),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatdescription
     */
    public function setChatDescription(int|string $chatId, ?string $description = null): FailResult|true
    {
        return $this->call(
            new SetChatDescription($chatId, $description),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     */
    public function setChatMenuButton(?int $chatId = null, ?MenuButton $menuButton = null): FailResult|true
    {
        return $this->call(new SetChatMenuButton($chatId, $menuButton));
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatpermissions
     */
    public function setChatPermissions(
        int|string $chatId,
        ChatPermissions $permissions,
        ?bool $useIndependentChatPermissions = null,
    ): FailResult|true {
        return $this->call(
            new SetChatPermissions($chatId, $permissions, $useIndependentChatPermissions),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatphoto
     */
    public function setChatPhoto(int|string $chatId, InputFile $photo): FailResult|true
    {
        return $this->call(
            new SetChatPhoto($chatId, $photo),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchatstickerset
     */
    public function setChatStickerSet(int|string $chatId, string $stickerSetName): FailResult|true
    {
        return $this->call(
            new SetChatStickerSet($chatId, $stickerSetName),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setchattitle
     */
    public function setChatTitle(int|string $chatId, string $title): FailResult|true
    {
        return $this->call(
            new SetChatTitle($chatId, $title),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
     */
    public function setCustomEmojiStickerSetThumbnail(string $name, ?string $customEmojiId = null): FailResult|true
    {
        return $this->call(new SetCustomEmojiStickerSetThumbnail($name, $customEmojiId));
    }

    /**
     * @see https://core.telegram.org/bots/api#setgamescore
     */
    public function setGameScore(
        int $userId,
        int $score,
        ?bool $force = null,
        ?bool $disableEditMessage = null,
        ?int $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
    ): FailResult|Message|true {
        return $this->call(
            new SetGameScore(
                $userId,
                $score,
                $force,
                $disableEditMessage,
                $chatId,
                $messageId,
                $inlineMessageId,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setmessagereaction
     *
     * @param ReactionType[]|null $reaction
     */
    public function setMessageReaction(
        int|string $chatId,
        int $messageId,
        ?array $reaction = null,
        ?bool $isBig = null,
    ): FailResult|true {
        return $this->call(
            new SetMessageReaction($chatId, $messageId, $reaction, $isBig),
        );
    }

    /**
     * @param BotCommand[] $commands
     *
     * @see https://core.telegram.org/bots/api#setmycommands
     */
    public function setMyCommands(
        array $commands,
        ?BotCommandScope $scope = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->call(new SetMyCommands($commands, $scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
     */
    public function setMyDefaultAdministratorRights(
        ?ChatAdministratorRights $rights = null,
        ?bool $forChannels = null,
    ): FailResult|true {
        return $this->call(new SetMyDefaultAdministratorRights($rights, $forChannels));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydescription
     */
    public function setMyDescription(?string $description = null, ?string $languageCode = null): FailResult|true
    {
        return $this->call(new SetMyDescription($description, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyname
     */
    public function setMyName(?string $name = null, ?string $languageCode = null): FailResult|true
    {
        return $this->call(new SetMyName($name, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyprofilephoto
     */
    public function setMyProfilePhoto(InputProfilePhoto $photo): FailResult|true
    {
        return $this->call(new SetMyProfilePhoto($photo));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyshortdescription
     */
    public function setMyShortDescription(
        ?string $shortDescription = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->call(new SetMyShortDescription($shortDescription, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param PassportElementError[] $errors
     */
    public function setPassportDataErrors(int $userId, array $errors): FailResult|true
    {
        return $this->call(new SetPassportDataErrors($userId, $errors));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickeremojilist
     *
     * @param string[] $emojiList
     */
    public function setStickerEmojiList(string $sticker, array $emojiList): FailResult|true
    {
        return $this->call(new SetStickerEmojiList($sticker, $emojiList));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickerkeywords
     *
     * @param string[]|null $keywords
     */
    public function setStickerKeywords(string $sticker, ?array $keywords = null): FailResult|true
    {
        return $this->call(new SetStickerKeywords($sticker, $keywords));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickermaskposition
     */
    public function setStickerMaskPosition(string $sticker, ?MaskPosition $maskPosition = null): FailResult|true
    {
        return $this->call(new SetStickerMaskPosition($sticker, $maskPosition));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     */
    public function setStickerPositionInSet(string $sticker, int $position): FailResult|true
    {
        return $this->call(new SetStickerPositionInSet($sticker, $position));
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickersetthumbnail
     */
    public function setStickerSetThumbnail(
        string $name,
        int $userId,
        string $format,
        InputFile|string|null $thumbnail = null,
    ): FailResult|true {
        return $this->call(
            new SetStickerSetThumbnail(
                $name,
                $userId,
                $format,
                $thumbnail,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setstickersettitle
     */
    public function setStickerSetTitle(string $name, string $title): FailResult|true
    {
        return $this->call(new SetStickerSetTitle($name, $title));
    }

    /**
     * @see https://core.telegram.org/bots/api#setuseremojistatus
     */
    public function setUserEmojiStatus(
        int $userId,
        ?string $emojiStatusCustomEmojiId = null,
        ?DateTimeImmutable $emojiStatusExpirationDate = null,
    ): FailResult|true {
        return $this->call(
            new SetUserEmojiStatus(
                $userId,
                $emojiStatusCustomEmojiId,
                $emojiStatusExpirationDate,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#setwebhook
     */
    public function setWebhook(
        string $url,
        ?string $ipAddress = null,
        ?int $maxConnections = null,
        ?array $allowUpdates = null,
        ?bool $dropPendingUpdates = null,
        #[SensitiveParameter]
        ?string $secretToken = null,
    ): FailResult|true {
        return $this->call(
            new SetWebhook($url, $ipAddress, $maxConnections, $allowUpdates, $dropPendingUpdates, $secretToken),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     */
    public function stopMessageLiveLocation(
        ?string $businessConnectionId = null,
        int|string|null $chatId = null,
        ?int $messageId = null,
        ?string $inlineMessageId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Message|true {
        return $this->call(
            new StopMessageLiveLocation(
                $businessConnectionId,
                $chatId,
                $messageId,
                $inlineMessageId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#stoppoll
     */
    public function stopPoll(
        int|string $chatId,
        int $messageId,
        ?string $businessConnectionId = null,
        ?InlineKeyboardMarkup $replyMarkup = null,
    ): FailResult|Poll {
        return $this->call(
            new StopPoll(
                $chatId,
                $messageId,
                $businessConnectionId,
                $replyMarkup,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#transferbusinessaccountstars
     */
    public function transferBusinessAccountStars(string $businessConnectionId, int $starCount): FailResult|true
    {
        return $this->call(
            new TransferBusinessAccountStars($businessConnectionId, $starCount),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#transfergift
     */
    public function transferGift(
        string $businessConnectionId,
        string $ownedGiftId,
        int $newOwnerChatId,
        ?int $starCount = null,
    ): FailResult|true {
        return $this->call(
            new TransferGift(
                $businessConnectionId,
                $ownedGiftId,
                $newOwnerChatId,
                $starCount,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unbanchatmember
     */
    public function unbanChatMember(
        int|string $chatId,
        int $userId,
        ?bool $onlyIfBanned = null,
    ): FailResult|true {
        return $this->call(
            new UnbanChatMember($chatId, $userId, $onlyIfBanned),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     */
    public function unbanChatSenderChat(int|string $chatId, int $senderChatId): FailResult|true
    {
        return $this->call(
            new UnbanChatSenderChat($chatId, $senderChatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unhidegeneralforumtopic
     */
    public function unhideGeneralForumTopic(int|string $chatId): FailResult|true
    {
        return $this->call(
            new UnhideGeneralForumTopic($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     */
    public function unpinChatMessage(int|string $chatId, ?int $messageId = null): FailResult|true
    {
        return $this->call(
            new UnpinChatMessage($chatId, $messageId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     */
    public function unpinAllChatMessages(int|string $chatId): FailResult|true
    {
        return $this->call(
            new UnpinAllChatMessages($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallforumtopicmessages
     */
    public function unpinAllForumTopicMessages(int|string $chatId, int $messageThreadId): FailResult|true
    {
        return $this->call(
            new UnpinAllForumTopicMessages($chatId, $messageThreadId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#unpinallgeneralforumtopicmessages
     */
    public function unpinAllGeneralForumTopicMessages(int|string $chatId): FailResult|true
    {
        return $this->call(
            new UnpinAllGeneralForumTopicMessages($chatId),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#upgradegift
     */
    public function upgradeGift(
        string $businessConnectionId,
        string $ownedGiftId,
        ?bool $keepOriginalDetails = null,
        ?int $starCount = null,
    ): FailResult|true {
        return $this->call(
            new UpgradeGift(
                $businessConnectionId,
                $ownedGiftId,
                $keepOriginalDetails,
                $starCount,
            ),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     */
    public function uploadStickerFile(int $userId, InputFile $sticker, string $stickerFormat): FailResult|File
    {
        return $this->call(
            new UploadStickerFile($userId, $sticker, $stickerFormat),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#verifychat
     */
    public function verifyChat(int|string $chatId, ?string $customDescription = null): FailResult|true
    {
        return $this->call(
            new VerifyChat($chatId, $customDescription),
        );
    }

    /**
     * @see https://core.telegram.org/bots/api#verifyuser
     */
    public function verifyUser(int $userId, ?string $customDescription = null): FailResult|true
    {
        return $this->call(
            new VerifyUser($userId, $customDescription),
        );
    }

    /**
     * @infection-ignore-all
     * @codeCoverageIgnore
     */
    private function createDefaultTransport(): TransportInterface
    {
        if (extension_loaded('curl')) {
            return new CurlTransport();
        }

        $availableNativeTransport = (bool) ini_get('allow_url_fopen');
        if ($availableNativeTransport) {
            return new NativeTransport();
        }

        throw new LogicException(
            'Failed to initialize the default transport. Enable cURL PHP extension or provide a transport manually.',
        );
    }
}
