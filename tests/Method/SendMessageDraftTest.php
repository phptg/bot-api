<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessageDraft;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SendMessageDraftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendMessageDraft(12, 100, 'hello');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendMessageDraft', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'draft_id' => 100,
                'text' => 'hello',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $method = new SendMessageDraft(
            12,
            100,
            'hello',
            99,
            'HTML',
            [$entity],
        );

        assertSame(
            [
                'chat_id' => 12,
                'message_thread_id' => 99,
                'draft_id' => 100,
                'text' => 'hello',
                'parse_mode' => 'HTML',
                'entities' => [$entity->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendMessageDraft(12, 100, 'hello');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
