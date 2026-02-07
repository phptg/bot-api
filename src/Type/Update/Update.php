<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Update;

use JsonException;
use Psr\Log\LoggerInterface;
use Phptg\BotApi\LogContextFactory;
use Phptg\BotApi\ParseResult\ResultFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Type\BusinessConnection;
use Phptg\BotApi\Type\BusinessMessagesDeleted;
use Phptg\BotApi\Type\CallbackQuery;
use Phptg\BotApi\Type\ChatBoostRemoved;
use Phptg\BotApi\Type\ChatBoostUpdated;
use Phptg\BotApi\Type\ChatJoinRequest;
use Phptg\BotApi\Type\ChatMemberUpdated;
use Phptg\BotApi\Type\Inline\ChosenInlineResult;
use Phptg\BotApi\Type\Inline\InlineQuery;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageReactionCountUpdated;
use Phptg\BotApi\Type\MessageReactionUpdated;
use Phptg\BotApi\Type\Payment\PaidMediaPurchased;
use Phptg\BotApi\Type\Payment\PreCheckoutQuery;
use Phptg\BotApi\Type\Payment\ShippingQuery;
use Phptg\BotApi\Type\Poll;
use Phptg\BotApi\Type\PollAnswer;

/**
 * @see https://core.telegram.org/bots/api#update
 *
 * @api
 */
final class Update
{
    private ?string $raw = null;
    private ?array $rawDecoded = null;

    public function __construct(
        public readonly int $updateId,
        public readonly ?Message $message = null,
        public readonly ?Message $editedMessage = null,
        public readonly ?Message $channelPost = null,
        public readonly ?Message $editedChannelPost = null,
        public readonly ?BusinessConnection $businessConnection = null,
        public readonly ?Message $businessMessage = null,
        public readonly ?Message $editedBusinessMessage = null,
        public readonly ?BusinessMessagesDeleted $deletedBusinessMessages = null,
        public readonly ?MessageReactionUpdated $messageReaction = null,
        public readonly ?MessageReactionCountUpdated $messageReactionCount = null,
        public readonly ?InlineQuery $inlineQuery = null,
        public readonly ?ChosenInlineResult $chosenInlineResult = null,
        public readonly ?CallbackQuery $callbackQuery = null,
        public readonly ?ShippingQuery $shippingQuery = null,
        public readonly ?PreCheckoutQuery $preCheckoutQuery = null,
        public readonly ?Poll $poll = null,
        public readonly ?PollAnswer $pollAnswer = null,
        public readonly ?ChatMemberUpdated $myChatMember = null,
        public readonly ?ChatMemberUpdated $chatMember = null,
        public readonly ?ChatJoinRequest $chatJoinRequest = null,
        public readonly ?ChatBoostUpdated $chatBoost = null,
        public readonly ?ChatBoostRemoved $removedChatBoost = null,
        public readonly ?PaidMediaPurchased $purchasedPaidMedia = null,
    ) {}

    /**
     * @psalm-template T as bool
     * @psalm-param T $decoded
     * @psalm-return (T is true ? array|null : string|null)
     */
    public function getRaw(bool $decoded = false): array|string|null
    {
        return $decoded ? $this->rawDecoded : $this->raw;
    }

    /**
     * Create a new `Update` object from JSON string.
     *
     * @throws TelegramParseResultException
     */
    public static function fromJson(string $json, ?LoggerInterface $logger = null): Update
    {
        try {
            $decodedJson = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $logger?->error(
                'Failed to decode JSON for "Update" type.',
                LogContextFactory::parseResultError($json),
            );
            throw new TelegramParseResultException('Failed to decode JSON.', previous: $e);
        }

        try {
            $update = (new ResultFactory())->create($decodedJson, new ObjectValue(self::class));
        } catch (TelegramParseResultException $exception) {
            $logger?->error(
                'Failed to parse "Update" data. ' . $exception->getMessage(),
                LogContextFactory::parseResultError($json),
            );
            throw $exception;
        }

        $update->raw = $json;
        $update->rawDecoded = $decodedJson;
        return $update;
    }
}
