<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Passport\EncryptedCredentials;
use Phptg\BotApi\Type\Passport\EncryptedPassportElement;
use Phptg\BotApi\Type\Passport\PassportData;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PassportDataTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedPassportElement = new EncryptedPassportElement('personal_details', '2');
        $encryptedCredentials = new EncryptedCredentials('a', 'b', 'c');
        $passportData = new PassportData(
            [$encryptedPassportElement],
            $encryptedCredentials,
        );

        assertSame([$encryptedPassportElement], $passportData->data);
        assertSame($encryptedCredentials, $passportData->credentials);
    }

    public function testFromTelegramResult(): void
    {
        $passportData = (new ObjectFactory())->create([
            'data' => [
                [
                    'type' => 'personal_details',
                    'hash' => 'test-hash',
                ],
            ],
            'credentials' => [
                'data' => '1',
                'hash' => '2',
                'secret' => '3',
            ],
        ], null, PassportData::class);

        assertCount(1, $passportData->data);
        assertInstanceOf(EncryptedPassportElement::class, $passportData->data[0]);
        assertSame('personal_details', $passportData->data[0]->type);
        assertSame('test-hash', $passportData->data[0]->hash);

        assertInstanceOf(EncryptedCredentials::class, $passportData->credentials);
        assertSame('1', $passportData->credentials->data);
        assertSame('2', $passportData->credentials->hash);
        assertSame('3', $passportData->credentials->secret);
    }
}
