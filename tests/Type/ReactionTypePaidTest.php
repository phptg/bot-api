<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ReactionTypePaid;

use function PHPUnit\Framework\assertSame;

final class ReactionTypePaidTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypePaid();

        assertSame('paid', $reaction->getType());
        assertSame(
            [
                'type' => 'paid',
            ],
            $reaction->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $reaction = (new ObjectFactory())->create(
            [
                'type' => 'paid',
            ],
            null,
            ReactionTypePaid::class,
        );

        assertSame('paid', $reaction->getType());
    }
}
