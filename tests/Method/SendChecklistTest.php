<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendChecklist;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputChecklist;
use Phptg\BotApi\Type\InputChecklistTask;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertSame;

final class SendChecklistTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendChecklist(
            'bcid1',
            12,
            new InputChecklist(
                'Title',
                [
                    new InputChecklistTask(1, 'Task 1'),
                    new InputChecklistTask(2, 'Task 2'),
                ],
            ),
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendChecklist', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'checklist' => [
                    'title' => 'Title',
                    'tasks' => [
                        ['id' => 1, 'text' => 'Task 1'],
                        ['id' => 2, 'text' => 'Task 2'],
                    ],
                ],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $checklist = new InputChecklist(
            'Title',
            [
                new InputChecklistTask(1, 'Task 1'),
                new InputChecklistTask(2, 'Task 2'),
            ],
        );
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new InlineKeyboardMarkup([]);
        $method = new SendChecklist(
            'bcid1',
            12,
            $checklist,
            true,
            false,
            'test',
            $replyParameters,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'checklist' => $checklist->toRequestArray(),
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'test',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendChecklist(
            'bcid1',
            12,
            new InputChecklist('Title', []),
        );

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
