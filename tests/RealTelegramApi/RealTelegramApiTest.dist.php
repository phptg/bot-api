<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\RealTelegramApi;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\TelegramBotApi;

#[Group('realApi')]
final class RealTelegramApiTest extends TestCase
{
    private const TOKEN = 'telegram-api-token';

    public function testBase(): void
    {
        $api = $this->createApi();

        $result = $api->getChat('@sergei_predvoditelev');

        var_dump($result);
    }

    private function createApi(): TelegramBotApi
    {
        return new TelegramBotApi(self::TOKEN);
    }
}
