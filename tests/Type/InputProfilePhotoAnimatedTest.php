<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputProfilePhoto;
use Phptg\BotApi\Type\InputProfilePhotoAnimated;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputProfilePhotoAnimatedTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new InputFile(null);
        $type = new InputProfilePhotoAnimated($animation);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('animated', $type->getType());
        assertSame($animation, $type->animation);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animated',
                'animation' => 'attach://file0',
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $animation,
            ],
            $fileCollector->get(),
        );
    }

    public function testFull(): void
    {
        $animation = new InputFile(null);
        $type = new InputProfilePhotoAnimated($animation, 2.5);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('animated', $type->getType());
        assertSame($animation, $type->animation);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animated',
                'animation' => 'attach://file0',
                'main_frame_timestamp' => 2.5,
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $animation,
            ],
            $fileCollector->get(),
        );
    }
}
