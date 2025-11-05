<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Passport\EncryptedCredentials;

use function PHPUnit\Framework\assertSame;

final class EncryptedCredentialsTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedCredentials = new EncryptedCredentials('1', '2', '3');

        assertSame('1', $encryptedCredentials->data);
        assertSame('2', $encryptedCredentials->hash);
        assertSame('3', $encryptedCredentials->secret);
    }

    public function testFromTelegramResult(): void
    {
        $encryptedCredentials = (new ObjectFactory())->create([
            'data' => '1',
            'hash' => '2',
            'secret' => '3',
        ], null, EncryptedCredentials::class);

        assertSame('1', $encryptedCredentials->data);
        assertSame('2', $encryptedCredentials->hash);
        assertSame('3', $encryptedCredentials->secret);
    }
}
