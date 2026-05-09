<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use DateTimeImmutable;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputPollMedia;
use Phptg\BotApi\Type\InputPollOption;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyKeyboardMarkup;
use Phptg\BotApi\Type\ReplyKeyboardRemove;
use Phptg\BotApi\Type\ReplyParameters;

/**
 * @see https://core.telegram.org/bots/api#sendpoll
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class SendPoll implements MethodInterface
{
    /**
     * @param InputPollOption[] $options
     * @param MessageEntity[]|null $questionEntities
     * @param int[]|null $correctOptionIds
     * @param MessageEntity[]|null $explanationEntities
     * @param MessageEntity[]|null $descriptionEntities
     * @param string[]|null $countryCodes
     */
    public function __construct(
        private int|string $chatId,
        private string $question,
        private array $options,
        private ?string $businessConnectionId = null,
        private ?int $messageThreadId = null,
        private ?string $questionParseMode = null,
        private ?array $questionEntities = null,
        private ?bool $isAnonymous = null,
        private ?string $type = null,
        private ?bool $allowsMultipleAnswers = null,
        private ?array $correctOptionIds = null,
        private ?string $explanation = null,
        private ?string $explanationParseMode = null,
        private ?array $explanationEntities = null,
        private ?InputPollMedia $explanationMedia = null,
        private ?int $openPeriod = null,
        private ?DateTimeImmutable $closeDate = null,
        private ?bool $isClosed = null,
        private ?InputPollMedia $media = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?string $messageEffectId = null,
        private ?ReplyParameters $replyParameters = null,
        private InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
        private ?bool $allowPaidBroadcast = null,
        private ?bool $allowsRevoting = null,
        private ?bool $shuffleOptions = null,
        private ?bool $allowAddingOptions = null,
        private ?bool $hideResultsUntilCloses = null,
        private ?bool $membersOnly = null,
        private ?array $countryCodes = null,
        private ?string $description = null,
        private ?string $descriptionParseMode = null,
        private ?array $descriptionEntities = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendPoll';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $options = array_map(
            static fn(InputPollOption $option) => $option->toRequestArray($fileCollector),
            $this->options,
        );
        $explanationMedia = $this->explanationMedia?->toRequestArray($fileCollector);
        $media = $this->media?->toRequestArray($fileCollector);

        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'question' => $this->question,
                'question_parse_mode' => $this->questionParseMode,
                'question_entities' => $this->questionEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->questionEntities,
                    ),
                'options' => $options,
                'is_anonymous' => $this->isAnonymous,
                'type' => $this->type,
                'allows_multiple_answers' => $this->allowsMultipleAnswers,
                'allows_revoting' => $this->allowsRevoting,
                'shuffle_options' => $this->shuffleOptions,
                'allow_adding_options' => $this->allowAddingOptions,
                'hide_results_until_closes' => $this->hideResultsUntilCloses,
                'members_only' => $this->membersOnly,
                'country_codes' => $this->countryCodes,
                'correct_option_ids' => $this->correctOptionIds,
                'explanation' => $this->explanation,
                'explanation_parse_mode' => $this->explanationParseMode,
                'explanation_entities' => $this->explanationEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->explanationEntities,
                    ),
                'explanation_media' => $explanationMedia,
                'open_period' => $this->openPeriod,
                'close_date' => $this->closeDate?->getTimestamp(),
                'is_closed' => $this->isClosed,
                'description' => $this->description,
                'description_parse_mode' => $this->descriptionParseMode,
                'description_entities' => $this->descriptionEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->descriptionEntities,
                    ),
                'media' => $media,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'allow_paid_broadcast' => $this->allowPaidBroadcast,
                'message_effect_id' => $this->messageEffectId,
                'reply_parameters' => $this->replyParameters?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
