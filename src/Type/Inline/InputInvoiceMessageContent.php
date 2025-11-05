<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use SensitiveParameter;
use Phptg\BotApi\Type\Payment\LabeledPrice;

/**
 * @see https://core.telegram.org/bots/api#inputinvoicemessagecontent
 *
 * @api
 */
final readonly class InputInvoiceMessageContent implements InputMessageContent
{
    /**
     * @param LabeledPrice[] $prices
     * @param int[] $suggestedTipAmounts
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $payload,
        public string $currency,
        public array $prices,
        #[SensitiveParameter]
        public ?string $providerToken = null,
        public ?int $maxTipAmount = null,
        public ?array $suggestedTipAmounts = null,
        public ?string $providerData = null,
        public ?string $photoUrl = null,
        public ?int $photoSize = null,
        public ?int $photoWidth = null,
        public ?int $photoHeight = null,
        public ?bool $needName = null,
        public ?bool $needPhoneNumber = null,
        public ?bool $needEmail = null,
        public ?bool $needShippingAddress = null,
        public ?bool $sendPhoneNumberToProvider = null,
        public ?bool $sendEmailToProvider = null,
        public ?bool $isFlexible = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'title' => $this->title,
                'description' => $this->description,
                'payload' => $this->payload,
                'provider_token' => $this->providerToken,
                'currency' => $this->currency,
                'prices' => array_map(
                    static fn(LabeledPrice $price) => $price->toRequestArray(),
                    $this->prices,
                ),
                'max_tip_amount' => $this->maxTipAmount,
                'suggested_tip_amounts' => $this->suggestedTipAmounts,
                'provider_data' => $this->providerData,
                'photo_url' => $this->photoUrl,
                'photo_size' => $this->photoSize,
                'photo_width' => $this->photoWidth,
                'photo_height' => $this->photoHeight,
                'need_name' => $this->needName,
                'need_phone_number' => $this->needPhoneNumber,
                'need_email' => $this->needEmail,
                'need_shipping_address' => $this->needShippingAddress,
                'send_phone_number_to_provider' => $this->sendPhoneNumberToProvider,
                'send_email_to_provider' => $this->sendEmailToProvider,
                'is_flexible' => $this->isFlexible,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
