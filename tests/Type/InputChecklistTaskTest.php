<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Constant\ParseMode;
use Phptg\BotApi\Type\InputChecklistTask;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputChecklistTaskTest extends TestCase
{
    public function testBase(): void
    {
        $task = new InputChecklistTask(1, 'Sample Task');

        assertSame(1, $task->id);
        assertSame('Sample Task', $task->text);
        assertNull($task->parseMode);
        assertNull($task->textEntities);

        assertSame(
            [
                'id' => 1,
                'text' => 'Sample Task',
            ],
            $task->toRequestArray(),
        );
    }

    public function testToRequestArray(): void
    {
        $task = new InputChecklistTask(
            1,
            'Sample Task',
            ParseMode::MARKDOWN_V2,
            [new MessageEntity('bold', 0, 5)],
        );

        assertSame(
            [
                'id' => 1,
                'text' => 'Sample Task',
                'parse_mode' => ParseMode::MARKDOWN_V2,
                'text_entities' => [
                    [
                        'type' => 'bold',
                        'offset' => 0,
                        'length' => 5,
                    ],
                ],
            ],
            $task->toRequestArray(),
        );
    }
}
