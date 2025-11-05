<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use Phptg\BotApi\Type\InputFile;

/**
 * @api
 */
interface TransportInterface
{
    public function get(string $url): ApiResponse;

    /**
     * @psalm-param array<string, string> $headers
     */
    public function post(string $url, string $body, array $headers): ApiResponse;

    /**
     * @psalm-param array<string, scalar> $data
     * @psalm-param array<string, InputFile> $files
     */
    public function postWithFiles(string $url, array $data, array $files): ApiResponse;

    /**
     * Downloads a file by URL.
     *
     * @param string $url The URL of the file to download.
     *
     * @return string The file content.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     */
    public function downloadFile(string $url): string;

    /**
     * Downloads a file by URL and saves it to a file.
     *
     * @param string $url The URL of the file to download.
     * @param string $savePath The path to save the file.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     * @throws SaveFileException If an error occurred while saving the file.
     */
    public function downloadFileTo(string $url, string $savePath): void;
}
