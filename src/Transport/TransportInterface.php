<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Phptg\BotApi\Type\InputFile;

/**
 * Interface for HTTP transport implementations.
 *
 * Defines the contract for making HTTP requests to the Telegram Bot API.
 *
 * @api
 */
interface TransportInterface
{
    /**
     * Performs a GET request.
     *
     * @param string $url The URL to request.
     *
     * @return ApiResponse The API response.
     */
    public function get(string $url): ApiResponse;

    /**
     * Performs a POST request.
     *
     * @param string $url The URL to request.
     * @param string $body The request body.
     * @param string[] $headers The request headers as an associative array (header name => header value).
     *
     * @return ApiResponse The API response.
     *
     * @psalm-param array<string, string> $headers
     */
    public function post(string $url, string $body, array $headers): ApiResponse;

    /**
     * Performs a POST request with file uploads.
     *
     * @param string $url The URL to request.
     * @param (bool|string|int|float)[] $data The form data fields as an associative array (field name => field value).
     * @param InputFile[] $files The files to upload as an associative array (field name => `InputFile`).
     *
     * @return ApiResponse The API response.
     *
     * @psalm-param array<string, scalar> $data
     * @psalm-param array<string, InputFile> $files
     */
    public function postWithFiles(string $url, array $data, array $files): ApiResponse;

    /**
     * Downloads a file by URL and returns a readable stream with its content. The returned resource is intended for
     * a single read — implementations are not required to return a seekable stream.
     *
     * @param string $url The URL of the file to download.
     *
     * @return resource A readable stream.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     */
    public function downloadFile(string $url): mixed;
}
