<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Transport\InputFileData;

/**
 * @api
 */
final readonly class CustomMimeTypeResolver implements MimeTypeResolverInterface
{
    /**
     * @psalm-param array<lowercase-string, string> $map
     */
    public function __construct(
        private array $map,
    ) {}

    public function resolve(InputFileData $fileData): ?string
    {
        $extension = $fileData->extension();
        if ($extension === null) {
            return null;
        }

        return $this->map[strtolower($extension)] ?? null;
    }
}
