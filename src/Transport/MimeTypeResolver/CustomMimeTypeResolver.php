<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport\MimeTypeResolver;

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

    public function resolve(InputFile $inputFile): ?string
    {
        $extension = $inputFile->extension();
        if ($extension === null) {
            return null;
        }

        return $this->map[strtolower($extension)] ?? null;
    }
}
