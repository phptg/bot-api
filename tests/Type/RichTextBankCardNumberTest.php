<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextBankCardNumber;

use function PHPUnit\Framework\assertSame;

final class RichTextBankCardNumberTest extends TestCase
{
    public function testBase(): void
    {
        $bankCardNumber = new RichTextBankCardNumber('hello', '4111111111111111');

        assertSame('bank_card_number', $bankCardNumber->getType());
        assertSame('hello', $bankCardNumber->text);
        assertSame('4111111111111111', $bankCardNumber->bankCardNumber);
    }

    public function testFromTelegramResult(): void
    {
        $bankCardNumber = (new ObjectFactory())->create([
            'type' => 'bank_card_number',
            'text' => 'hello',
            'bank_card_number' => '4111111111111111',
        ], null, RichTextBankCardNumber::class);

        assertSame('bank_card_number', $bankCardNumber->getType());
        assertSame('hello', $bankCardNumber->text);
        assertSame('4111111111111111', $bankCardNumber->bankCardNumber);
    }
}
