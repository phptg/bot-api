<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\InputProfilePhoto;

/**
 * @see https://core.telegram.org/bots/api#setmyprofilephoto
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class SetMyProfilePhoto implements MethodInterface
{
    public function __construct(
        private InputProfilePhoto $photo,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMyProfilePhoto';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $photo = $this->photo->toRequestArray($fileCollector);

        return [
            'photo' => $photo,
            ...$fileCollector->get(),
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
