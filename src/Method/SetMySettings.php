<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#setmysettings
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetMySettings implements MethodInterface
{
    public function __construct(
        private ?bool $supportsInlineQueries = null,
        private ?string $inlineQueryPlaceholder = null,
        private ?bool $needsInlineQueryLocation = null,
        private ?int $inlineFeedbackShareDenominator = null,
        private ?bool $canJoinGroups = null,
        private ?bool $canReadAllGroupMessages = null,
        private ?bool $canConnectToBusiness = null,
        private ?bool $canManageBots = null,
        private ?bool $supportsGuestQueries = null,
        private ?bool $supportsJoinRequestQueries = null,
        private ?bool $hasTopicsEnabled = null,
        private ?bool $allowsUsersToCreateTopics = null,
        private ?bool $hasTopicSidebar = null,
        private ?bool $canCommunicateWithBots = null,
        private ?string $callbackQueryMode = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMySettings';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'supports_inline_queries' => $this->supportsInlineQueries,
                'inline_query_placeholder' => $this->inlineQueryPlaceholder,
                'needs_inline_query_location' => $this->needsInlineQueryLocation,
                'inline_feedback_share_denominator' => $this->inlineFeedbackShareDenominator,
                'can_join_groups' => $this->canJoinGroups,
                'can_read_all_group_messages' => $this->canReadAllGroupMessages,
                'can_connect_to_business' => $this->canConnectToBusiness,
                'can_manage_bots' => $this->canManageBots,
                'supports_guest_queries' => $this->supportsGuestQueries,
                'supports_join_request_queries' => $this->supportsJoinRequestQueries,
                'has_topics_enabled' => $this->hasTopicsEnabled,
                'allows_users_to_create_topics' => $this->allowsUsersToCreateTopics,
                'has_topic_sidebar' => $this->hasTopicSidebar,
                'can_communicate_with_bots' => $this->canCommunicateWithBots,
                'callback_query_mode' => $this->callbackQueryMode,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
