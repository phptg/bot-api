<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetChatPhoto;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile('/path/to/photo.jpg');
        $method = new SetChatPhoto(1, $photo);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatPhoto', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'photo' => $photo,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $photo = new InputFile('/path/to/photo.jpg');
        $method = new SetChatPhoto(1, $photo);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
