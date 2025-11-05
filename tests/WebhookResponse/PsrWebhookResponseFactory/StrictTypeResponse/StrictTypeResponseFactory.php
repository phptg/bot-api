<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\WebhookResponse\PsrWebhookResponseFactory\StrictTypeResponse;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class StrictTypeResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return new StrictTypeResponse($code, $reasonPhrase);
    }
}
