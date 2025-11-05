<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Inline\SentWebAppMessage;

use function PHPUnit\Framework\assertSame;

final class SentWebAppMessageTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SentWebAppMessage('id1');

        assertSame('id1', $type->inlineMessageId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'inline_message_id' => 'id1',
        ], null, SentWebAppMessage::class);

        assertSame('id1', $type->inlineMessageId);
    }
}
