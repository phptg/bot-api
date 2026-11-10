<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\VerifyUser;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class VerifyUserTest extends TestCase
{
    public function testBase(): void
    {
        $method = new VerifyUser(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('verifyUser', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new VerifyUser(
            1,
            'test',
            'MarkdownV2',
            [new MessageEntity('text_link', 0, 4, 'https://example.com')],
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('verifyUser', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'custom_description' => 'test',
                'custom_description_parse_mode' => 'MarkdownV2',
                'custom_description_entities' => [
                    [
                        'type' => 'text_link',
                        'offset' => 0,
                        'length' => 4,
                        'url' => 'https://example.com',
                    ],
                ],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new VerifyUser(5);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
