<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendRichMessageDraft;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InputRichMessage;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SendRichMessageDraftTest extends TestCase
{
    public function testBase(): void
    {
        $richMessage = new InputRichMessage(html: '<b>Hello</b>');
        $method = new SendRichMessageDraft(12, 1, $richMessage);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendRichMessageDraft', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'draft_id' => 1,
                'rich_message' => $richMessage->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $richMessage = new InputRichMessage(html: '<b>Hello</b>', isRtl: true);
        $method = new SendRichMessageDraft(12, 1, $richMessage, 99);

        assertSame(
            [
                'chat_id' => 12,
                'message_thread_id' => 99,
                'draft_id' => 1,
                'rich_message' => $richMessage->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendRichMessageDraft(12, 1, new InputRichMessage(html: '<b>Hello</b>'));

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
