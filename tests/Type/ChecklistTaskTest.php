<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChecklistTask;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChecklistTaskTest extends TestCase
{
    public function testBase(): void
    {
        $checklistTask = new ChecklistTask(19, 'Test task');

        assertSame(19, $checklistTask->id);
        assertSame('Test task', $checklistTask->text);
        assertNull($checklistTask->textEntities);
        assertNull($checklistTask->completedByUser);
        assertNull($checklistTask->completionDate);
    }

    public function testFromTelegramResult(): void
    {
        $checklistTask = (new ObjectFactory())->create(
            [
                'id' => 19,
                'text' => 'Test task',
                'text_entities' => [
                    [
                        'type' => 'bold',
                        'offset' => 0,
                        'length' => 4,
                    ],
                ],
                'completed_by_user' => [
                    'id' => 12345,
                    'is_bot' => false,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'johndoe',
                ],
                'completion_date' => 1633036800,
            ],
            null,
            ChecklistTask::class,
        );

        assertSame(19, $checklistTask->id);
        assertSame('Test task', $checklistTask->text);

        assertCount(1, $checklistTask->textEntities);
        assertInstanceOf(MessageEntity::class, $checklistTask->textEntities[0]);
        assertSame('bold', $checklistTask->textEntities[0]->type);
        assertSame(0, $checklistTask->textEntities[0]->offset);
        assertSame(4, $checklistTask->textEntities[0]->length);

        assertInstanceOf(User::class, $checklistTask->completedByUser);
        assertSame(12345, $checklistTask->completedByUser->id);
        assertFalse($checklistTask->completedByUser->isBot);
        assertSame('John', $checklistTask->completedByUser->firstName);
        assertSame('Doe', $checklistTask->completedByUser->lastName);
        assertSame('johndoe', $checklistTask->completedByUser->username);

        assertSame(1633036800, $checklistTask->completionDate?->getTimestamp());
    }
}
