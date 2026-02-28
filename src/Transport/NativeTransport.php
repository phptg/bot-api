<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Phptg\BotApi\Transport\ResourceReader\NativeResourceReader;
use Phptg\BotApi\Transport\ResourceReader\ResourceReaderInterface;
use RuntimeException;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\MimeTypeResolverInterface;
use Phptg\BotApi\Type\InputFile;

use function is_string;
use function json_encode;

/**
 * @see https://www.php.net/manual/function.file-get-contents.php
 * @see https://www.php.net/manual/function.file-put-contents.php
 *
 * @api
 */
final readonly class NativeTransport implements TransportInterface
{
    /**
     * @param MimeTypeResolverInterface $mimeTypeResolver MIME type resolver for determining file types. Defaults
     * to {@see ApacheMimeTypeResolver}.
     * @param ResourceReaderInterface[] $resourceReaders List of resource readers to handle different resource types.
     */
    public function __construct(
        private MimeTypeResolverInterface $mimeTypeResolver = new ApacheMimeTypeResolver(),
        private array $resourceReaders = [
            new NativeResourceReader(),
        ],
    ) {}

    public function get(string $url): ApiResponse
    {
        return $this->send(
            $url,
            ['method' => 'GET'],
        );
    }

    public function post(string $url, string $body, array $headers): ApiResponse
    {
        $header = [];
        foreach ($headers as $name => $value) {
            $header[] = $name . ': ' . $value;
        }

        return $this->send(
            $url,
            [
                'method' => 'POST',
                'header' => $header,
                'content' => $body,
            ],
        );
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        $boundary = uniqid('', true);
        $content = $this->buildMultipartFormData($data, $files, $boundary);
        $contentType = 'multipart/form-data; boundary=' . $boundary . '; charset=utf-8';

        return $this->send(
            $url,
            [
                'method' => 'POST',
                'header' => 'Content-type: ' . $contentType,
                'content' => $content,
            ],
        );
    }

    public function downloadFile(string $url): mixed
    {
        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new DownloadFileException($errorString);
            },
        );
        try {
            /**
             * @var resource $stream We throw exception on error, so `fopen()` returns resource.
             */
            $stream = fopen($url, 'rb');
        } finally {
            restore_error_handler();
        }

        return $stream;
    }

    private function send(string $url, array $options): ApiResponse
    {
        global $http_response_header;

        $options['ignore_errors'] = true;

        $context = stream_context_create(['http' => $options]);

        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new RuntimeException($errorString);
            },
        );
        try {
            /**
             * @var string $body We throw an exception on error, so `file_get_contents()` returns the string.
             */
            $body = file_get_contents($url, context: $context);
        } finally {
            restore_error_handler();
        }

        /**
         * @psalm-var non-empty-list<string> $http_response_header
         * @see https://www.php.net/manual/reserved.variables.httpresponseheader.php
         */

        return new ApiResponse(
            $this->parseStatusCode($http_response_header),
            $body,
        );
    }

    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-param array<string, InputFile> $files
     */
    private function buildMultipartFormData(array $data, array $files, string $boundary): string
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = "--$boundary";
            $result[] = "Content-Disposition: form-data; name=\"$key\"";
            $result[] = '';
            $result[] = is_string($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        foreach ($files as $key => $file) {
            $fileData = new InputFileData($file, $this->resourceReaders);
            $mimeType = $this->mimeTypeResolver->resolve($fileData);
            $filename = $fileData->basename();

            $contentDisposition = "Content-Disposition: form-data; name=\"$key\"";
            if ($filename !== null) {
                $contentDisposition .= "; filename=\"$filename\"";
            }

            $result[] = "--$boundary";
            $result[] = $contentDisposition;
            if ($mimeType !== null) {
                $result[] = "Content-Type: $mimeType";
            }
            $result[] = '';
            $result[] = $fileData->read();
        }

        $result[] = "--$boundary--";
        $result[] = '';

        return implode("\r\n", $result);
    }

    /**
     * @psalm-param non-empty-list<string> $headers
     */
    private function parseStatusCode(array $headers): int
    {
        return preg_match('/HTTP\/\d+\.\d+ (\d+)/', $headers[0], $matches)
            ? (int) $matches[1]
            : 0;
    }
}
