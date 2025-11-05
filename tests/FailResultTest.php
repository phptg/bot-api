<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\ApiResponse;
use Phptg\BotApi\FailResult;
use Phptg\BotApi\CustomMethod;
use Phptg\BotApi\Type\ResponseParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class FailResultTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $result = new FailResult($method, $response);

        assertSame($method, $result->method);
        assertSame($response, $result->response);
        assertNull($result->description);
        assertNull($result->parameters);
        assertNull($result->errorCode);
    }

    public function testFull(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $responseParameters = new ResponseParameters();
        $result = new FailResult($method, $response, 'desc', $responseParameters, 200);

        assertSame($method, $result->method);
        assertSame($response, $result->response);
        assertSame('desc', $result->description);
        assertSame($responseParameters, $result->parameters);
        assertSame(200, $result->errorCode);
    }
}
