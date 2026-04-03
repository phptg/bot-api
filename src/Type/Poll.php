<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;

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
     * @param int[]|null $correctOptionIds
     * @param MessageEntity[]|null $explanationEntities
     * @param MessageEntity[]|null $descriptionEntities
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
        public bool $allowsRevoting,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $questionEntities = null,
        #[ArrayMap(IntegerValue::class)]
        public ?array $correctOptionIds = null,
        public ?string $explanation = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $explanationEntities = null,
        public ?int $openPeriod = null,
        public ?int $closeDate = null,
        public ?string $description = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $descriptionEntities = null,
    ) {}
}
