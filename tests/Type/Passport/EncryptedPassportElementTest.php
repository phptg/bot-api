<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Passport\EncryptedPassportElement;
use Phptg\BotApi\Type\Passport\PassportFile;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class EncryptedPassportElementTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedPassportElement = new EncryptedPassportElement('personal_details', '2');

        assertSame('personal_details', $encryptedPassportElement->type);
        assertSame('2', $encryptedPassportElement->hash);
        assertNull($encryptedPassportElement->data);
        assertNull($encryptedPassportElement->phoneNumber);
        assertNull($encryptedPassportElement->email);
        assertNull($encryptedPassportElement->files);
        assertNull($encryptedPassportElement->frontSide);
        assertNull($encryptedPassportElement->reverseSide);
        assertNull($encryptedPassportElement->selfie);
        assertNull($encryptedPassportElement->translation);
    }

    public function testFromTelegramResult(): void
    {
        $encryptedPassportElement = (new ObjectFactory())->create([
            'type' => 'personal_details',
            'hash' => 'test-hash',
            'data' => 'test-data',
            'phone_number' => '+71231234567',
            'email' => 'test@example.com',
            'files' => [
                [
                    'file_id' => '5',
                    'file_unique_id' => '6',
                    'file_size' => 7,
                    'file_date' => 1717512173,
                ],
            ],
            'front_side' => [
                'file_id' => '8',
                'file_unique_id' => '9',
                'file_size' => 10,
                'file_date' => 1717512174,
            ],
            'reverse_side' => [
                'file_id' => '11',
                'file_unique_id' => '12',
                'file_size' => 13,
                'file_date' => 1717512175,
            ],
            'selfie' => [
                'file_id' => '14',
                'file_unique_id' => '15',
                'file_size' => 16,
                'file_date' => 1717512176,
            ],
            'translation' => [
                [
                    'file_id' => '17',
                    'file_unique_id' => '18',
                    'file_size' => 19,
                    'file_date' => 1717512177,
                ],
            ],
        ], null, EncryptedPassportElement::class);

        assertSame('personal_details', $encryptedPassportElement->type);
        assertSame('test-hash', $encryptedPassportElement->hash);
        assertSame('test-data', $encryptedPassportElement->data);
        assertSame('+71231234567', $encryptedPassportElement->phoneNumber);
        assertSame('test@example.com', $encryptedPassportElement->email);

        assertIsArray($encryptedPassportElement->files);
        assertCount(1, $encryptedPassportElement->files);
        assertInstanceOf(PassportFile::class, $encryptedPassportElement->files[0]);
        assertSame('5', $encryptedPassportElement->files[0]->fileId);

        assertInstanceOf(PassportFile::class, $encryptedPassportElement->frontSide);
        assertSame('8', $encryptedPassportElement->frontSide->fileId);

        assertInstanceOf(PassportFile::class, $encryptedPassportElement->reverseSide);
        assertSame('11', $encryptedPassportElement->reverseSide->fileId);

        assertInstanceOf(PassportFile::class, $encryptedPassportElement->selfie);
        assertSame('14', $encryptedPassportElement->selfie->fileId);

        assertIsArray($encryptedPassportElement->translation);
        assertCount(1, $encryptedPassportElement->translation);
        assertInstanceOf(PassportFile::class, $encryptedPassportElement->translation[0]);
        assertSame('17', $encryptedPassportElement->translation[0]->fileId);
    }
}
