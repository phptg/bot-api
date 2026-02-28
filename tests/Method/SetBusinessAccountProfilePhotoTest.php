<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Method\SetBusinessAccountProfilePhoto;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputProfilePhotoStatic;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile(null);
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountProfilePhoto', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'photo' => $photo->toRequestArray(new FileCollector()),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile(null);
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo, true);

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'photo' => $photo->toRequestArray(new FileCollector()),
                'is_public' => true,
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $file = new InputFile(null);
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
