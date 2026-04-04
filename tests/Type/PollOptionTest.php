<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PollOption;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PollOptionTest extends TestCase
{
    public function testBase(): void
    {
        $option = new PollOption('pid1', 'A', 25);

        assertSame('pid1', $option->persistentId);
        assertSame('A', $option->text);
        assertSame(25, $option->voterCount);
        assertNull($option->textEntities);
        assertNull($option->addedByUser);
        assertNull($option->addedByChat);
        assertNull($option->additionDate);
    }

    public function testFromTelegramResult(): void
    {
        $option = (new ObjectFactory())->create([
            'persistent_id' => 'pid1',
            'text' => 'A',
            'voter_count' => 25,
            'text_entities' => [
                [
                    'offset' => 23,
                    'length' => 1,
                    'type' => 'bold',
                ],
            ],
            'added_by_user' => [
                'id' => 42,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'added_by_chat' => [
                'id' => 100,
                'type' => 'group',
            ],
            'addition_date' => 1700000000,
        ], null, PollOption::class);

        assertSame('pid1', $option->persistentId);
        assertSame('A', $option->text);
        assertSame(25, $option->voterCount);

        assertCount(1, $option->textEntities);
        assertSame(23, $option->textEntities[0]->offset);

        assertSame(42, $option->addedByUser->id);
        assertSame(100, $option->addedByChat->id);
        assertSame(1700000000, $option->additionDate);
    }
}
