<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopicReopened;

use function PHPUnit\Framework\assertSame;

final class ForumTopicReopenedTest extends TestCase
{
    public function testBase(): void
    {
        assertSame([], get_object_vars(new ForumTopicReopened()));
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, ForumTopicReopened::class);
        $this->expectNotToPerformAssertions();
    }
}
