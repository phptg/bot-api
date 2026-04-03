<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use Phptg\BotApi\Type\PreparedKeyboardButton;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SavePreparedKeyboardButton;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\KeyboardButton;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class SavePreparedKeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new KeyboardButton('Test Button');
        $method = new SavePreparedKeyboardButton(123, $button);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('savePreparedKeyboardButton', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
                'button' => [
                    'text' => 'Test Button',
                ],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $button = new KeyboardButton('Test Button');
        $method = new SavePreparedKeyboardButton(123, $button);

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 'prepared_btn_789',
        ])->call($method);

        assertInstanceOf(PreparedKeyboardButton::class, $preparedResult);
        assertSame('prepared_btn_789', $preparedResult->id);
    }
}
