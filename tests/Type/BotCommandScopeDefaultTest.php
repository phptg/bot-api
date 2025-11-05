<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeDefault;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeDefaultTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeDefault();

        assertSame('default', $scope->getType());

        assertSame(
            [
                'type' => 'default',
            ],
            $scope->toRequestArray(),
        );
    }
}
