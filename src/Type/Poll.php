<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#poll
 *
 * @api
 */
final readonly class Poll
{
    /**
     * @param MessageEntity[]|null $questionEntities
     * @param PollOption[] $options
     * @param MessageEntity[]|null $explanationEntities
     */
    public function __construct(
        public string $id,
        public string $question,
        #[ArrayOfObjectsValue(PollOption::class)]
        public array $options,
        public int $totalVoterCount,
        public bool $isClosed,
        public bool $isAnonymous,
        public string $type,
        public bool $allowsMultipleAnswers,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $questionEntities = null,
        public ?int $correctOptionId = null,
        public ?string $explanation = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $explanationEntities = null,
        public ?int $openPeriod = null,
        public ?int $closeDate = null,
    ) {}
}
