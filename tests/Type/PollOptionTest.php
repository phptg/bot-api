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
        $option = new PollOption('A', 25);

        assertSame('A', $option->text);
        assertSame(25, $option->voterCount);
        assertNull($option->textEntities);
    }

    public function testFromTelegramResult(): void
    {
        $option = (new ObjectFactory())->create([
            'text' => 'A',
            'voter_count' => 25,
            'text_entities' => [
                [
                    'offset' => 23,
                    'length' => 1,
                    'type' => 'bold',
                ],
            ],
        ], null, PollOption::class);

        assertSame('A', $option->text);
        assertSame(25, $option->voterCount);

        assertCount(1, $option->textEntities);
        assertSame(23, $option->textEntities[0]->offset);
    }
}
