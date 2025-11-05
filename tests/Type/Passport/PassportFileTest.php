<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Passport\PassportFile;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

final class PassportFileTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $passportFile = new PassportFile('1', '2', 3, $date);

        assertSame('1', $passportFile->fileId);
        assertSame('2', $passportFile->fileUniqueId);
        assertSame(3, $passportFile->fileSize);
        assertSame($date, $passportFile->fileDate);
    }

    public function testFromTelegramResult(): void
    {
        $passportFile = (new ObjectFactory())->create([
            'file_id' => '1',
            'file_unique_id' => '2',
            'file_size' => 3,
            'file_date' => 1717512173,
        ], null, PassportFile::class);

        assertSame('1', $passportFile->fileId);
        assertSame('2', $passportFile->fileUniqueId);
        assertSame(3, $passportFile->fileSize);
        assertEquals(new DateTimeImmutable('@1717512173'), $passportFile->fileDate);
    }
}
