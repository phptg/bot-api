<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChecklistTasksDone;
use Phptg\BotApi\Type\Message;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChecklistTasksDoneTest extends TestCase
{
    public function testBase(): void
    {
        $type = new ChecklistTasksDone();

        assertNull($type->checklistMessage);
        assertNull($type->markedAsDoneTaskIds);
        assertNull($type->markedAsNotDoneTaskIds);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([], null, ChecklistTasksDone::class);

        assertNull($type->checklistMessage);
        assertNull($type->markedAsDoneTaskIds);
        assertNull($type->markedAsNotDoneTaskIds);
    }

    public function testFromTelegramResultFull(): void
    {
        $result = [
            'checklist_message' => [
                'message_id' => 17,
                'date' => 1620000001,
                'chat' => [
                    'id' => 2,
                    'type' => 'private',
                ],
            ],
            'marked_as_done_task_ids' => [1, 2],
            'marked_as_not_done_task_ids' => [7, 8, 9],
        ];

        $type = (new ObjectFactory())->create($result, null, ChecklistTasksDone::class);

        assertInstanceOf(Message::class, $type->checklistMessage);
        assertSame(17, $type->checklistMessage->messageId);

        assertSame([1, 2], $type->markedAsDoneTaskIds);
        assertSame([7, 8, 9], $type->markedAsNotDoneTaskIds);
    }
}
