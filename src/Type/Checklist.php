<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#checklist
 *
 * @api
 */
final readonly class Checklist
{
    /**
     * @param ChecklistTask[] $tasks
     * @param MessageEntity[]|null $titleEntities
     */
    public function __construct(
        public string $title,
        #[ArrayOfObjectsValue(ChecklistTask::class)]
        public array $tasks,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $titleEntities = null,
        public ?true $othersCanAddTasks = null,
        public ?true $othersCanMarkTasksAsDone = null,
    ) {}
}
