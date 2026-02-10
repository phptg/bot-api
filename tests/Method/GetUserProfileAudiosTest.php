<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetUserProfileAudios;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class GetUserProfileAudiosTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserProfileAudios(123);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUserProfileAudios', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetUserProfileAudios(
            123,
            1,
            2,
        );

        assertSame(
            [
                'user_id' => 123,
                'offset' => 1,
                'limit' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserProfileAudios(123);

        $preparedResult = TestHelper::createSuccessStubApi([
            'total_count' => 1,
            'audios' => [
                [
                    'file_id' => 'file_id',
                    'file_unique_id' => 'file_unique_id',
                    'duration' => 120,
                    'performer' => 'performer',
                    'title' => 'title',
                ],
            ],
        ])->call($method);

        assertSame(1, $preparedResult->totalCount);
        assertCount(1, $preparedResult->audios);
        assertSame('file_id', $preparedResult->audios[0]->fileId);
    }
}
