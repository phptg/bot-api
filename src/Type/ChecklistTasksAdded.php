<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#checklisttasksadded
 *
 * @api
 */
final readonly class ChecklistTasksAdded
{
    /**
     * @param ChecklistTask[] $tasks
     */
    public function __construct(
        #[ArrayOfObjectsValue(ChecklistTask::class)]
        public array $tasks,
        public ?Message $checklistMessage = null,
    ) {}
}
