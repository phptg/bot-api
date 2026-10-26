<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerror
 *
 * @api
 */
interface PassportElementError
{
    public function getSource(): string;

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array;
}
