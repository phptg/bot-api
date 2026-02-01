<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use CurlShareHandle;
use CURLStringFile;
use Phptg\BotApi\Curl\Curl;
use Phptg\BotApi\Curl\CurlException;
use Phptg\BotApi\Curl\CurlInterface;
use Phptg\BotApi\Transport\ResourceReader\NativeResourceReader;
use Phptg\BotApi\Transport\ResourceReader\ResourceReaderInterface;
use Phptg\BotApi\Transport\ResourceReader\StreamResourceReader;

use function is_int;

/**
 * @api
 */
final readonly class CurlTransport implements TransportInterface
{
    private CurlShareHandle $curlShareHandle;

    /**
     * @param ResourceReaderInterface[] $resourceReaders List of resource readers to handle different resource types.
     * @param CurlInterface $curl cURL interface implementation for making HTTP requests.
     */
    public function __construct(
        private array $resourceReaders = [
            new NativeResourceReader(),
            new StreamResourceReader(),
        ],
        private CurlInterface $curl = new Curl(),
    ) {
        $this->curlShareHandle = $this->createCurlShareHandle();
    }

    public function get(string $url): ApiResponse
    {
        $options = [
            CURLOPT_HTTPGET => true,
            CURLOPT_URL => $url,
        ];
        return $this->send($options);
    }

    public function post(string $url, string $body, array $headers): ApiResponse
    {
        $header = [];
        foreach ($headers as $name => $value) {
            $header[] = $name . ': ' . $value;
        }

        $options = [
            CURLOPT_POST => true,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $header,
        ];
        return $this->send($options);
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        foreach ($files as $key => $file) {
            $data[$key] = new CURLStringFile(
                (new InputFileData($file, $this->resourceReaders))->read(),
                $file->filename ?? '',
            );
        }

        $options = [
            CURLOPT_POST => true,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
        ];
        return $this->send($options);
    }

    public function downloadFile(string $url): string
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SHARE => $this->curlShareHandle,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);

            /**
             * @var string $result `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
             */
            $result = $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }

        return $result;
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new SaveFileException($errorString);
            },
        );
        try {
            $fileHandler = fopen($savePath, 'wb');
        } finally {
            restore_error_handler();
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_FILE => $fileHandler,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SHARE => $this->curlShareHandle,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);
            $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }
    }

    private function send(array $options): ApiResponse
    {
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_SHARE] = $this->curlShareHandle;

        $curl = $this->curl->init();

        try {
            $this->curl->setopt_array($curl, $options);

            /**
             * @var string $body `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
             */
            $body = $this->curl->exec($curl);

            $statusCode = $this->curl->getinfo($curl, CURLINFO_HTTP_CODE);
            if (!is_int($statusCode)) {
                $statusCode = 0;
            }
        } finally {
            $this->curl->close($curl);
        }

        return new ApiResponse($statusCode, $body);
    }

    private function createCurlShareHandle(): CurlShareHandle
    {
        $handle = curl_share_init();
        $this->curl->share_setopt($handle, CURLSHOPT_SHARE, CURL_LOCK_DATA_COOKIE);
        $this->curl->share_setopt($handle, CURLSHOPT_SHARE, CURL_LOCK_DATA_DNS);
        $this->curl->share_setopt($handle, CURLSHOPT_SHARE, CURL_LOCK_DATA_SSL_SESSION);
        return $handle;
    }
}
