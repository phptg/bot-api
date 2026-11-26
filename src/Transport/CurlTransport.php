<?php

declare(strict_types=1);

namespace Phptg\BotApi\Transport;

use CurlShareHandle;
use CURLFile;
use CURLStringFile;
use RuntimeException;
use Phptg\BotApi\Curl\Curl;
use Phptg\BotApi\Curl\CurlException;
use Phptg\BotApi\Curl\CurlInterface;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\MimeTypeResolverInterface;
use Phptg\BotApi\Type\InputFile;

use function is_int;
use function is_string;

/**
 * @api
 */
final readonly class CurlTransport implements TransportInterface
{
    private CurlShareHandle $curlShareHandle;

    /**
     * @param MimeTypeResolverInterface $mimeTypeResolver MIME type resolver for determining file types. Defaults
     * to {@see ApacheMimeTypeResolver}.
     * @param positive-int|null $timeout Maximum time in seconds for each API request. Sets the cURL `CURLOPT_TIMEOUT`
     * option for `get()`, `post()` and `postWithFiles()`. For `longPoll()` the limit is extended to the long
     * polling timeout plus 10 seconds, when it is greater. `null` means the option is not set.
     * @param positive-int|null $downloadFileTimeout Maximum time in seconds for {@see CurlTransport::downloadFile()}.
     * Sets the cURL `CURLOPT_TIMEOUT` option for it. `null` means the option is not set.
     * @param string|null $proxy Proxy server URL, for example `socks5://user:password@127.0.0.1:1080` or
     * `http://127.0.0.1:3128`. Sets the cURL `CURLOPT_PROXY` option. All schemes supported by cURL are allowed.
     * `null` means the option is not set.
     * @param array<int, mixed> $extraCurlOptions Additional cURL options applied to every request, for example
     * `[CURLOPT_HTTPHEADER => ['User-Agent: MyBot/1.0'], CURLOPT_VERBOSE => true]`. They take precedence over
     * the options set by the parameters above and by the transport itself, so be careful not to break
     * the request. Defaults to an empty array.
     * @param CurlInterface $curl cURL interface implementation for making HTTP requests.
     */
    public function __construct(
        private MimeTypeResolverInterface $mimeTypeResolver = new ApacheMimeTypeResolver(),
        private ?int $timeout = null,
        private ?int $downloadFileTimeout = null,
        private ?string $proxy = null,
        private array $extraCurlOptions = [],
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
        return $this->send($options, $this->timeout);
    }

    public function longPoll(string $url, int $timeout): ApiResponse
    {
        $options = [
            CURLOPT_HTTPGET => true,
            CURLOPT_URL => $url,
        ];
        $requestTimeout = $this->timeout === null ? null : max($this->timeout, $timeout + 10);
        return $this->send($options, $requestTimeout);
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
        return $this->send($options, $this->timeout);
    }

    public function postWithFiles(string $url, array $data, array $files): ApiResponse
    {
        foreach ($files as $key => $file) {
            $data[$key] = $this->toCurlFile($file);
        }

        $options = [
            CURLOPT_POST => true,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
        ];
        return $this->send($options, $this->timeout);
    }

    private function toCurlFile(InputFile $file): CURLFile|CURLStringFile
    {
        $mimeType = $this->mimeTypeResolver->resolve($file);

        if (is_string($file->pathOrResource)) {
            return new CURLFile($file->pathOrResource, $mimeType, $file->filename());
        }

        $metadata = stream_get_meta_data($file->pathOrResource);
        if (isset($metadata['uri']) && !str_contains($metadata['uri'], '://')) {
            return new CURLFile($metadata['uri'], $mimeType, $file->filename());
        }

        if ($metadata['seekable']) {
            rewind($file->pathOrResource);
        }

        $contents = stream_get_contents($file->pathOrResource);
        if ($contents === false) {
            // `stream_get_contents()` can return false only on error, but we can't trigger it in tests.
            throw new RuntimeException('Failed to read the stream.'); // @codeCoverageIgnore
        }

        return new CURLStringFile($contents, $file->filename() ?? '', $mimeType ?? 'application/octet-stream');
    }

    public function downloadFile(string $url): mixed
    {
        /**
         * @var resource $stream `php://temp` always opens successfully.
         */
        $stream = fopen('php://temp', 'r+b');

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_FILE => $stream,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SHARE => $this->curlShareHandle,
        ];
        if ($this->downloadFileTimeout !== null) {
            $options[CURLOPT_TIMEOUT] = $this->downloadFileTimeout;
        }
        if ($this->proxy !== null) {
            $options[CURLOPT_PROXY] = $this->proxy;
        }
        $options = $this->extraCurlOptions + $options;

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
        }

        rewind($stream);

        return $stream;
    }

    /**
     * @param array<int, mixed> $options
     * @param positive-int|null $timeout Maximum time in seconds for the request. `null` means no limit.
     */
    private function send(array $options, ?int $timeout): ApiResponse
    {
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_SHARE] = $this->curlShareHandle;
        if ($timeout !== null) {
            $options[CURLOPT_TIMEOUT] = $timeout;
        }
        if ($this->proxy !== null) {
            $options[CURLOPT_PROXY] = $this->proxy;
        }
        $options = $this->extraCurlOptions + $options;

        $curl = $this->curl->init();

        $this->curl->setopt_array($curl, $options);

        /**
         * @var string $body `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
         */
        $body = $this->curl->exec($curl);

        $statusCode = $this->curl->getinfo($curl, CURLINFO_HTTP_CODE);
        if (!is_int($statusCode)) {
            $statusCode = 0;
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
