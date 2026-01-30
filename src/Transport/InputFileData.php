<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use LogicException;
use Phptg\BotApi\Transport\ResourceReader\ResourceReaderInterface;
use Phptg\BotApi\Type\InputFile;

/**
 * Wrapper for {@see InputFile} that provides data reading and metadata extraction.
 */
final readonly class InputFileData
{
    private ResourceReaderInterface $reader;

    /**
     * @param ResourceReaderInterface[] $readers
     */
    public function __construct(
        private InputFile $inputFile,
        array $readers,
    ) {
        $this->reader = $this->resolveReader($readers);
    }

    /**
     * Reads the content of the input file.
     *
     * @return string The file content.
     */
    public function read(): string
    {
        return $this->reader->read($this->inputFile->resource);
    }

    /**
     * Returns the file extension.
     *
     * @return string|null The file extension, or null if it cannot be determined.
     */
    public function extension(): ?string
    {
        $filepath = $this->filepath();
        return $filepath === null
            ? null
            : pathinfo($filepath, PATHINFO_EXTENSION);
    }

    /**
     * Returns the base name of the file.
     *
     * @return string|null The file base name, or null if it cannot be determined.
     */
    public function basename(): ?string
    {
        $filepath = $this->filepath();
        return $filepath === null
            ? null
            : basename($filepath);
    }

    /**
     * Returns the file path.
     *
     * @return string|null The file path, or null if it cannot be determined.
     */
    private function filepath(): ?string
    {
        if ($this->inputFile->filename !== null) {
            return $this->inputFile->filename;
        }

        $uri = $this->reader->getUri($this->inputFile->resource);

        if (str_contains($uri, '://')) {
            return null;
        }

        return $uri;
    }

    /**
     * Resolves the appropriate reader for the input file resource.
     *
     * @param ResourceReaderInterface[] $readers Available readers.
     *
     * @return ResourceReaderInterface The resolved reader.
     *
     * @throws LogicException If no suitable reader is found.
     */
    private function resolveReader(array $readers): ResourceReaderInterface
    {
        foreach ($readers as $reader) {
            if ($reader->supports($this->inputFile->resource)) {
                return $reader;
            }
        }

        throw new LogicException('No suitable resource reader found.');
    }
}
