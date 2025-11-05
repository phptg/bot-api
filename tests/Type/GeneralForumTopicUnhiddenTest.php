<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GeneralForumTopicUnhidden;

final class GeneralForumTopicUnhiddenTest extends TestCase
{
    public function testBase(): void
    {
        new GeneralForumTopicUnhidden();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GeneralForumTopicUnhidden::class);
        $this->expectNotToPerformAssertions();
    }
}
