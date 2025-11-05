<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\DeleteMyCommands;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\BotCommandScopeDefault;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMyCommands();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMyCommands', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $scope = new BotCommandScopeDefault();
        $method = new DeleteMyCommands($scope, 'ru');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMyCommands', $method->getApiMethod());
        assertSame(
            [
                'scope' => $scope->toRequestArray(),
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteMyCommands();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
