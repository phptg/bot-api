<?php

declare(strict_types=1);

namespace Type\Inline;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Inline\PreparedInlineMessage;

use function PHPUnit\Framework\assertSame;

final class PreparedInlineMessageTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $type = new PreparedInlineMessage('id1', $date);

        assertSame('id1', $type->id);
        assertSame($date, $type->expirationDate);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'id' => 'id1',
            'expiration_date' => 1731917185,
        ], null, PreparedInlineMessage::class);

        assertSame('id1', $type->id);
        assertSame(1731917185, $type->expirationDate->getTimestamp());
    }
}
