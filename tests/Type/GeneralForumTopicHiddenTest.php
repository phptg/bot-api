<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GeneralForumTopicHidden;

final class GeneralForumTopicHiddenTest extends TestCase
{
    public function testBase(): void
    {
        new GeneralForumTopicHidden();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GeneralForumTopicHidden::class);
        $this->expectNotToPerformAssertions();
    }
}
