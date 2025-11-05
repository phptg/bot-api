<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Payment\CreateInvoiceLink;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Payment\LabeledPrice;

use function PHPUnit\Framework\assertSame;

final class CreateInvoiceLinkTest extends TestCase
{
    public function testBase(): void
    {
        $price = new LabeledPrice('The label', 100);
        $method = new CreateInvoiceLink(
            'The title',
            'The description',
            'The payload',
            'XTR',
            [$price],
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createInvoiceLink', $method->getApiMethod());
        assertSame(
            [
                'title' => 'The title',
                'description' => 'The description',
                'payload' => 'The payload',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $price = new LabeledPrice('The label', 100);
        $method = new CreateInvoiceLink(
            'The title',
            'The description',
            'The payload',
            'XTR',
            [$price],
            'The provider token',
            2,
            [3, 4],
            'The provider data',
            'https://example.com/photo.jpg',
            126687,
            100,
            120,
            true,
            false,
            false,
            true,
            true,
            true,
            false,
            11,
            'buid1',
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createInvoiceLink', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'buid1',
                'title' => 'The title',
                'description' => 'The description',
                'payload' => 'The payload',
                'provider_token' => 'The provider token',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
                'subscription_period' => 11,
                'max_tip_amount' => 2,
                'suggested_tip_amounts' => [3, 4],
                'provider_data' => 'The provider data',
                'photo_url' => 'https://example.com/photo.jpg',
                'photo_size' => 126687,
                'photo_width' => 100,
                'photo_height' => 120,
                'need_name' => true,
                'need_phone_number' => false,
                'need_email' => false,
                'need_shipping_address' => true,
                'send_phone_number_to_provider' => true,
                'send_email_to_provider' => true,
                'is_flexible' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateInvoiceLink(
            'The title',
            'The description',
            'The payload',
            'XTR',
            [],
        );

        $preparedResult = TestHelper::createSuccessStubApi('https://example.com/invoice')->call($method);

        assertSame('https://example.com/invoice', $preparedResult);
    }
}
