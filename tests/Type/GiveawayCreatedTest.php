<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GiveawayCreated;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class GiveawayCreatedTest extends TestCase
{
    public function testBase(): void
    {
        $object = new GiveawayCreated();

        assertNull($object->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'prize_star_count' => 23,
            ],
            null,
            GiveawayCreated::class,
        );

        assertSame(23, $object->prizeStarCount);
    }
}
