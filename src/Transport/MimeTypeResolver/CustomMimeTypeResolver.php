<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

use Phptg\BotApi\Transport\FileHelper;
use Phptg\BotApi\Type\InputFile;

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

    public function resolve(InputFile $file): ?string
    {
        $extension = FileHelper::extension($file);
        if ($extension === null) {
            return null;
        }

        return $this->map[strtolower($extension)] ?? null;
    }
}
