<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Checklist;
use Phptg\BotApi\Type\ChecklistTask;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChecklistTest extends TestCase
{
    public function testBase(): void
    {
        $tasks = [
            new ChecklistTask(1, 'Task 1'),
            new ChecklistTask(2, 'Task 2'),
        ];
        $checklist = new Checklist('My Checklist', $tasks);

        assertSame('My Checklist', $checklist->title);
        assertSame($tasks, $checklist->tasks);
        assertNull($checklist->titleEntities);
        assertNull($checklist->othersCanAddTasks);
        assertNull($checklist->othersCanMarkTasksAsDone);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'title' => 'My Checklist',
            'tasks' => [
                ['id' => 1, 'text' => 'Task 1'],
                ['id' => 2, 'text' => 'Task 2'],
            ],
            'title_entities' => [
                ['type' => 'bold', 'offset' => 0, 'length' => 4],
            ],
            'others_can_add_tasks' => true,
            'others_can_mark_tasks_as_done' => true,
        ];

        $checklist = (new ObjectFactory())->create($result, null, Checklist::class);

        assertSame('My Checklist', $checklist->title);

        assertCount(2, $checklist->tasks);
        assertSame(1, $checklist->tasks[0]->id);
        assertSame('Task 1', $checklist->tasks[0]->text);
        assertSame(2, $checklist->tasks[1]->id);
        assertSame('Task 2', $checklist->tasks[1]->text);

        assertCount(1, $checklist->titleEntities);
        assertSame('bold', $checklist->titleEntities[0]->type);
        assertSame(0, $checklist->titleEntities[0]->offset);
        assertSame(4, $checklist->titleEntities[0]->length);

        assertTrue($checklist->othersCanAddTasks);
        assertTrue($checklist->othersCanMarkTasksAsDone);
    }
}
