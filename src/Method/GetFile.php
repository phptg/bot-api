<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\File;

/**
 * @see https://core.telegram.org/bots/api#getfile
 *
 * @template-implements MethodInterface<File>
 */
final readonly class GetFile implements MethodInterface
{
    public function __construct(
        private string $fileId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getFile';
    }

    public function getData(): array
    {
        return [
            'file_id' => $this->fileId,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(File::class);
    }
}
