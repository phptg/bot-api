<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\AcceptedGiftTypes;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AcceptedGiftTypesTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $type = new AcceptedGiftTypes(true, false, true, false, true);

        assertTrue($type->unlimitedGifts);
        assertFalse($type->limitedGifts);
        assertTrue($type->uniqueGifts);
        assertFalse($type->premiumSubscription);
        assertTrue($type->giftsFromChannels);
        assertSame(
            [
                'unlimited_gifts' => true,
                'limited_gifts' => false,
                'unique_gifts' => true,
                'premium_subscription' => false,
                'gifts_from_channels' => true,
            ],
            $type->toRequestArray(),
        );
    }
}
