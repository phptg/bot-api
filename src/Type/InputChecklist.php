<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inputchecklist
 *
 * @api
 */
final readonly class InputChecklist
{
    /**
     * @param InputChecklistTask[] $tasks
     * @param MessageEntity[]|null $titleEntities
     */
    public function __construct(
        public string $title,
        public array $tasks,
        public ?string $parseMode = null,
        public ?array $titleEntities = null,
        public ?bool $othersCanAddTasks = null,
        public ?true $othersCanMarkTasksAsDone = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'title' => $this->title,
                'parse_mode' => $this->parseMode,
                'title_entities' => $this->titleEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->titleEntities,
                    ),
                'tasks' => array_map(
                    static fn(InputChecklistTask $task) => $task->toRequestArray(),
                    $this->tasks,
                ),
                'others_can_add_tasks' => $this->othersCanAddTasks,
                'others_can_mark_tasks_as_done' => $this->othersCanMarkTasksAsDone,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
