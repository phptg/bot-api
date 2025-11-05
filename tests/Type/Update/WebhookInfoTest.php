<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Update;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Update\WebhookInfo;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class WebhookInfoTest extends TestCase
{
    public function testBase(): void
    {
        $info = new WebhookInfo('https://example.com/', false, 12);

        assertSame('https://example.com/', $info->url);
        assertFalse($info->hasCustomCertificate);
        assertSame(12, $info->pendingUpdateCount);
        assertNull($info->ipAddress);
        assertNull($info->lastErrorDate);
        assertNull($info->lastErrorMessage);
        assertNull($info->lastSynchronizationErrorDate);
        assertNull($info->maxConnections);
        assertNull($info->allowedUpdates);
    }

    public function testFromTelegramResult(): void
    {
        $info = (new ObjectFactory())->create([
            'url' => 'https://example.com/',
            'has_custom_certificate' => true,
            'pending_update_count' => 12,
            'ip_address' => '127.0.0.1',
            'last_error_date' => 1717501903,
            'last_error_message' => 'test error',
            'last_synchronization_error_date' => 1717501904,
            'max_connections' => 15,
            'allowed_updates' => ['update1', 'update2'],
        ], null, WebhookInfo::class);

        assertSame('https://example.com/', $info->url);
        assertTrue($info->hasCustomCertificate);
        assertSame(12, $info->pendingUpdateCount);
        assertSame('127.0.0.1', $info->ipAddress);
        assertEquals(new DateTimeImmutable('@1717501903'), $info->lastErrorDate);
        assertSame('test error', $info->lastErrorMessage);
        assertEquals(new DateTimeImmutable('@1717501904'), $info->lastSynchronizationErrorDate);
        assertSame(15, $info->maxConnections);
        assertSame(['update1', 'update2'], $info->allowedUpdates);
    }
}
