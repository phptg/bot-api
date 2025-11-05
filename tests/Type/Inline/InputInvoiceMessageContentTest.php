<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputInvoiceMessageContent;
use Phptg\BotApi\Type\Payment\LabeledPrice;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputInvoiceMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $price = new LabeledPrice('label', 10);
        $type = new InputInvoiceMessageContent(
            'Title',
            'Description',
            'Payload',
            'XTR',
            [$price],
        );

        assertSame('Title', $type->title);
        assertSame('Description', $type->description);
        assertSame('Payload', $type->payload);
        assertSame('XTR', $type->currency);
        assertSame([$price], $type->prices);
        assertNull($type->providerToken);
        assertNull($type->maxTipAmount);
        assertNull($type->suggestedTipAmounts);
        assertNull($type->providerData);
        assertNull($type->photoUrl);
        assertNull($type->photoSize);
        assertNull($type->photoWidth);
        assertNull($type->photoHeight);
        assertNull($type->needName);
        assertNull($type->needPhoneNumber);
        assertNull($type->needEmail);
        assertNull($type->needShippingAddress);
        assertNull($type->sendPhoneNumberToProvider);
        assertNull($type->sendEmailToProvider);
        assertNull($type->isFlexible);

        assertSame(
            [
                'title' => 'Title',
                'description' => 'Description',
                'payload' => 'Payload',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $price = new LabeledPrice('label', 10);
        $type = new InputInvoiceMessageContent(
            'Title',
            'Description',
            'Payload',
            'XTR',
            [$price],
            'ProviderToken',
            100,
            [10, 20, 30],
            'ProviderData',
            'https://example.com/photo.png',
            205654,
            1024,
            768,
            true,
            false,
            true,
            true,
            true,
            true,
            false,
        );

        assertSame('Title', $type->title);
        assertSame('Description', $type->description);
        assertSame('Payload', $type->payload);
        assertSame('XTR', $type->currency);
        assertSame([$price], $type->prices);
        assertSame('ProviderToken', $type->providerToken);
        assertSame(100, $type->maxTipAmount);
        assertSame([10, 20, 30], $type->suggestedTipAmounts);
        assertSame('ProviderData', $type->providerData);
        assertSame('https://example.com/photo.png', $type->photoUrl);
        assertSame(205654, $type->photoSize);
        assertSame(1024, $type->photoWidth);
        assertSame(768, $type->photoHeight);
        assertTrue($type->needName);
        assertFalse($type->needPhoneNumber);
        assertTrue($type->needEmail);
        assertTrue($type->needShippingAddress);
        assertTrue($type->sendPhoneNumberToProvider);
        assertTrue($type->sendEmailToProvider);
        assertFalse($type->isFlexible);

        assertSame(
            [
                'title' => 'Title',
                'description' => 'Description',
                'payload' => 'Payload',
                'provider_token' => 'ProviderToken',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
                'max_tip_amount' => 100,
                'suggested_tip_amounts' => [10, 20, 30],
                'provider_data' => 'ProviderData',
                'photo_url' => 'https://example.com/photo.png',
                'photo_size' => 205654,
                'photo_width' => 1024,
                'photo_height' => 768,
                'need_name' => true,
                'need_phone_number' => false,
                'need_email' => true,
                'need_shipping_address' => true,
                'send_phone_number_to_provider' => true,
                'send_email_to_provider' => true,
                'is_flexible' => false,
            ],
            $type->toRequestArray(),
        );
    }
}
