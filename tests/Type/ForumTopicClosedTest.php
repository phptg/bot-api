<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopicClosed;

use function PHPUnit\Framework\assertSame;

final class ForumTopicClosedTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new ForumTopicClosed()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, ForumTopicClosed::class);
        $this->expectNotToPerformAssertions();
    }
}
