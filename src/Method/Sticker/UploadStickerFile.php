<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\File;
use Phptg\BotApi\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#uploadstickerfile
 *
 * @template-implements MethodInterface<File>
 */
final readonly class UploadStickerFile implements MethodInterface
{
    public function __construct(
        private int $userId,
        private InputFile $sticker,
        private string $stickerFormat,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'uploadStickerFile';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'sticker' => $this->sticker,
            'sticker_format' => $this->stickerFormat,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(File::class);
    }
}
