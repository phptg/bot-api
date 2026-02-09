<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UserProfileAudios;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class UserProfileAudiosTest extends TestCase
{
    public function testBase(): void
    {
        $userProfileAudios = new UserProfileAudios(5, []);

        assertSame(5, $userProfileAudios->totalCount);
        assertSame([], $userProfileAudios->audios);
    }

    public function testFromTelegramResult(): void
    {
        $userProfileAudios = (new ObjectFactory())->create([
            'total_count' => 2,
            'audios' => [
                [
                    'file_id' => 'audio_f1',
                    'file_unique_id' => 'audio_fu1',
                    'duration' => 180,
                    'performer' => 'Artist 1',
                    'title' => 'Song 1',
                ],
                [
                    'file_id' => 'audio_f2',
                    'file_unique_id' => 'audio_fu2',
                    'duration' => 240,
                    'performer' => 'Artist 2',
                    'title' => 'Song 2',
                ],
            ],
        ], null, UserProfileAudios::class);

        assertSame(2, $userProfileAudios->totalCount);
        assertCount(2, $userProfileAudios->audios);
        assertSame('audio_f1', $userProfileAudios->audios[0]->fileId);
        assertSame('audio_f2', $userProfileAudios->audios[1]->fileId);
    }
}
