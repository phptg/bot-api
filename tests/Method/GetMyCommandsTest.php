<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMyCommands;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\BotCommand;
use Phptg\BotApi\Type\BotCommandScopeDefault;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyCommands();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyCommands', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $scope = new BotCommandScopeDefault();
        $method = new GetMyCommands($scope, 'ru');

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
        $method = new GetMyCommands();

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'command' => 'start',
                'description' => 'Start command',
            ],
        ])->call($method);

        assertCount(1, $preparedResult);
        assertInstanceOf(BotCommand::class, $preparedResult[0]);
        assertSame('start', $preparedResult[0]->command);
    }
}
