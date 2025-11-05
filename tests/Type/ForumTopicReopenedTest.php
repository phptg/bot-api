<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopicReopened;

final class ForumTopicReopenedTest extends TestCase
{
    public function testBase(): void
    {
        new ForumTopicReopened();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, ForumTopicReopened::class);
        $this->expectNotToPerformAssertions();
    }
}
