<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SharedUser;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SharedUserTest extends TestCase
{
    public function testBase(): void
    {
        $sharedUser = new SharedUser(23);

        assertSame(23, $sharedUser->userId);
        assertNull($sharedUser->firstName);
        assertNull($sharedUser->lastName);
        assertNull($sharedUser->username);
        assertNull($sharedUser->photo);
    }

    public function testFromTelegramResult(): void
    {
        $sharedUser = (new ObjectFactory())->create([
            'user_id' => 23,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'bat',
            'photo' => [
                [
                    'file_id' => 'file_id-124',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 23,
                    'height' => 42,
                ],
            ],
        ], null, SharedUser::class);

        assertSame(23, $sharedUser->userId);
        assertSame('John', $sharedUser->firstName);
        assertSame('Doe', $sharedUser->lastName);
        assertSame('bat', $sharedUser->username);

        assertCount(1, $sharedUser->photo);
        assertSame('file_id-124', $sharedUser->photo[0]->fileId);
    }
}
