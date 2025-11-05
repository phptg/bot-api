<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Passport\SetPassportDataErrors;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Passport\PassportElementErrorSelfie;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetPassportDataErrorsTest extends TestCase
{
    public function testBase(): void
    {
        $error = new PassportElementErrorSelfie('driver_license', 'qwerty', 'Test message');
        $method = new SetPassportDataErrors(1, [$error]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setPassportDataErrors', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'errors' => [$error->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetPassportDataErrors(1, []);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
