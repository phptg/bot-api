<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputPollOption;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputPollOptionTest extends TestCase
{
    public function testBase(): void
    {
        $option = new InputPollOption();

        assertNull($option->text);
        assertNull($option->textParseMode);
        assertNull($option->textEntities);

        assertSame([], $option->toRequestArray());
    }

    public function testFilled(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $option = new InputPollOption('test', 'MarkdownV2', [$messageEntity]);

        assertSame('test', $option->text);
        assertSame('MarkdownV2', $option->textParseMode);
        assertSame([$messageEntity], $option->textEntities);

        assertSame(
            [
                'text' => 'test',
                'text_parse_mode' => 'MarkdownV2',
                'text_entities' => [$messageEntity->toRequestArray()],
            ],
            $option->toRequestArray(),
        );
    }
}
