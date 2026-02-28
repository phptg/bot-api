<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Method\SetMyProfilePhoto;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputProfilePhotoStatic;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMyProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile(null);
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetMyProfilePhoto($photo);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMyProfilePhoto', $method->getApiMethod());
        assertSame(
            [
                'photo' => $photo->toRequestArray(new FileCollector()),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $file = new InputFile(null);
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetMyProfilePhoto($photo);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
