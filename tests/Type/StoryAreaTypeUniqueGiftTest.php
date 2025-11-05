<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\StoryAreaTypeUniqueGift;

use function PHPUnit\Framework\assertSame;

final class StoryAreaTypeUniqueGiftTest extends TestCase
{
    public function testBase(): void
    {
        $uniqueGift = new StoryAreaTypeUniqueGift(
            name: 'Golden Trophy',
        );

        assertSame('Golden Trophy', $uniqueGift->name);
        assertSame('unique_gift', $uniqueGift->getType());

        assertSame(
            [
                'type' => 'unique_gift',
                'name' => 'Golden Trophy',
            ],
            $uniqueGift->toRequestArray(),
        );
    }
}
