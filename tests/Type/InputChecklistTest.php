<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputChecklist;
use Phptg\BotApi\Type\InputChecklistTask;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputChecklistTest extends TestCase
{
    public function testBase(): void
    {
        $tasks = [
            new InputChecklistTask(1, 'Input Task 1'),
            new InputChecklistTask(2, 'Input Task 2'),
        ];
        $inputChecklist = new InputChecklist('My Input Checklist', $tasks);

        assertSame('My Input Checklist', $inputChecklist->title);
        assertSame($tasks, $inputChecklist->tasks);
        assertNull($inputChecklist->parseMode);
        assertNull($inputChecklist->titleEntities);
        assertNull($inputChecklist->othersCanAddTasks);
        assertNull($inputChecklist->othersCanMarkTasksAsDone);

        assertSame(
            [
                'title' => 'My Input Checklist',
                'tasks' => [
                    ['id' => 1, 'text' => 'Input Task 1'],
                    ['id' => 2, 'text' => 'Input Task 2'],
                ],
            ],
            $inputChecklist->toRequestArray(),
        );
    }

    public function testToRequestArrayWithOptionalFields(): void
    {
        $inputChecklist = new InputChecklist(
            'My Input Checklist',
            [
                new InputChecklistTask(1, 'Input Task 1'),
                new InputChecklistTask(2, 'Input Task 2'),
            ],
            'MarkdownV2',
            [new MessageEntity('bold', 0, 5)],
            false,
            true,
        );

        assertSame(
            [
                'title' => 'My Input Checklist',
                'parse_mode' => 'MarkdownV2',
                'title_entities' => [
                    ['type' => 'bold', 'offset' => 0, 'length' => 5],
                ],
                'tasks' => [
                    ['id' => 1, 'text' => 'Input Task 1'],
                    ['id' => 2, 'text' => 'Input Task 2'],
                ],
                'others_can_add_tasks' => false,
                'others_can_mark_tasks_as_done' => true,
            ],
            $inputChecklist->toRequestArray(),
        );
    }
}
