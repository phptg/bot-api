<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\CurlTransport;

use CurlShareHandle;
use CURLFile;
use CURLStringFile;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Tests\Curl\CurlMock;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertArrayNotHasKey;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CurlTransportTest extends TestCase
{
    public function testGet(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->get('//url/getMe?key=value&array=%5B1%2C%22test%22%5D');

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertCount(4, $options);
        assertTrue($options[CURLOPT_HTTPGET]);
        assertSame('//url/getMe?key=value&array=%5B1%2C%22test%22%5D', $options[CURLOPT_URL]);
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testLongPoll(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->longPoll('//url/getUpdates?timeout=30', 30);

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertCount(4, $options);
        assertTrue($options[CURLOPT_HTTPGET]);
        assertSame('//url/getUpdates?timeout=30', $options[CURLOPT_URL]);
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testPost(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->post(
            '//url/logOut',
            '',
            [
                'Content-Length' => '0',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        );

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertCount(6, $options);
        assertTrue($options[CURLOPT_POST]);
        assertSame('//url/logOut', $options[CURLOPT_URL]);
        assertSame('', $options[CURLOPT_POSTFIELDS]);
        assertSame(
            [
                'Content-Length: 0',
                'Content-Type: application/json; charset=utf-8',
            ],
            $options[CURLOPT_HTTPHEADER],
        );
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testWithoutCode(): void
    {
        $transport = new CurlTransport(
            curl: new CurlMock(
                execResult: '{"ok":true,"result":[]}',
            ),
        );

        $response = $transport->get('getMe');

        assertSame(0, $response->statusCode);
    }

    public function testPostWithLocalFiles(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $response = $transport->postWithFiles(
            '//url/sendPhoto',
            [],
            [
                'photo1' => new InputFile(__DIR__ . '/photo.png'),
                'photo2' => new InputFile(__DIR__ . '/photo.png', 'photo.png'),
            ],
        );

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertCount(5, $options);
        assertTrue($options[CURLOPT_POST]);
        assertSame('//url/sendPhoto', $options[CURLOPT_URL]);
        assertEquals(
            [
                'photo1' => new CURLFile(__DIR__ . '/photo.png', 'image/png', 'photo.png'),
                'photo2' => new CURLFile(__DIR__ . '/photo.png', 'image/png', 'photo.png'),
            ],
            $options[CURLOPT_POSTFIELDS],
        );
        assertTrue($options[CURLOPT_RETURNTRANSFER]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function dataPostWithLocalFileByUri(): iterable
    {
        $path = str_replace('\\', '/', __DIR__ . '/photo.png');
        yield 'file URI' => ['file://' . $path, $path];
        yield 'file URI with Windows drive letter path' => ['file:///C:/dir/photo.png', 'C:/dir/photo.png'];
    }

    #[DataProvider('dataPostWithLocalFileByUri')]
    public function testPostWithLocalFileByUri(string $uri, string $expectedPath): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        $transport->postWithFiles('//url/sendPhoto', [], ['photo' => new InputFile($uri)]);

        assertEquals(
            ['photo' => new CURLFile($expectedPath, 'image/png', 'photo.png')],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    #[TestWith(['text/plain', 'test.txt'])]
    #[TestWith(['application/octet-stream', 'data.bin'])]
    #[TestWith(['application/octet-stream', null])]
    public function testPostWithResource(string $mimeType, ?string $filename): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $resource = TestHelper::openFile('php://memory', 'r+');
        fwrite($resource, 'stream content');

        $transport->postWithFiles(
            '//url/method',
            [],
            ['file' => new InputFile($resource, $filename)],
        );

        fclose($resource);

        $postFields = $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null;
        assertIsArray($postFields);
        assertInstanceOf(CURLStringFile::class, $postFields['file']);
        assertSame('stream content', $postFields['file']->data);
        assertSame($filename ?? '', $postFields['file']->postname);
        assertSame($mimeType, $postFields['file']->mime);
    }

    public function testPostWithResourceWithoutUri(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        [$resource, $pair] = TestHelper::createSocketPair();
        fwrite($pair, 'socket content');
        fclose($pair);

        $transport->postWithFiles(
            '//url/method',
            [],
            ['file' => new InputFile($resource)],
        );

        fclose($resource);

        $postFields = $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null;
        assertIsArray($postFields);
        assertInstanceOf(CURLStringFile::class, $postFields['file']);
        assertSame('socket content', $postFields['file']->data);
        assertSame('', $postFields['file']->postname);
    }

    public function testPostWithDataResource(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        $resource = TestHelper::openFile('data://text/plain,hi', 'r');
        $transport->postWithFiles('//url/method', [], ['file' => new InputFile($resource)]);
        fclose($resource);

        $postFields = $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null;
        assertIsArray($postFields);
        assertEquals(new CURLStringFile('hi', '', 'application/octet-stream'), $postFields['file']);
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function dataPostWithLocalFileResource(): iterable
    {
        $path = str_replace('\\', '/', __DIR__ . '/photo.png');
        yield 'plain path' => [$path, $path];
        yield 'file URI' => ['file://' . $path, $path];
        yield 'file URI with localhost host' => ['file://localhost/' . ltrim($path, '/'), $path];
        yield 'file URI in uppercase' => ['FILE://LOCALHOST/' . ltrim($path, '/'), $path];
    }

    #[DataProvider('dataPostWithLocalFileResource')]
    public function testPostWithLocalFileResource(string $uri, string $expectedPath): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        $resource = TestHelper::openFile($uri, 'r');
        stream_get_contents($resource);
        $transport->postWithFiles('//url/sendPhoto', [], ['photo' => new InputFile($resource)]);
        fclose($resource);

        assertEquals(
            ['photo' => new CURLFile($expectedPath, 'image/png', 'photo.png')],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testPostWithTmpFile(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport(curl: $curl);

        $resource = tmpfile();
        assertNotFalse($resource);
        $path = stream_get_meta_data($resource)['uri'] ?? null;
        assertNotNull($path);
        $transport->postWithFiles('//url/sendPhoto', [], ['photo' => new InputFile($resource)]);
        fclose($resource);

        assertEquals(
            ['photo' => new CURLFile($path, null, basename($path))],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testShareOptions(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );

        (new CurlTransport(curl: $curl))->get('getMe');

        assertSame(
            [
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_COOKIE],
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_DNS],
                [CURLSHOPT_SHARE, CURL_LOCK_DATA_SSL_SESSION],
            ],
            $curl->getShareOptions(),
        );
    }

    public function testTimeout(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl, timeout: 2);

        $transport->post('//url/logOut', '', []);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(2, $options[CURLOPT_TIMEOUT]);

        $transport->downloadFile('https://example.test/hello.jpg');

        $downloadOptions = $curl->getOptions();
        assertNotNull($downloadOptions);
        assertArrayNotHasKey(CURLOPT_TIMEOUT, $downloadOptions);
    }

    /**
     * @param positive-int|null $transportTimeout
     * @param positive-int $longPollingTimeout
     */
    #[TestWith([null, 30, null])]
    #[TestWith([30, 50, 60])]
    #[TestWith([30, 5, 30])]
    public function testLongPollTimeout(?int $transportTimeout, int $longPollingTimeout, ?int $expected): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl, timeout: $transportTimeout);

        $transport->longPoll('//url/getUpdates', $longPollingTimeout);

        $options = $curl->getOptions();
        assertNotNull($options);
        if ($expected === null) {
            assertArrayNotHasKey(CURLOPT_TIMEOUT, $options);
        } else {
            assertSame($expected, $options[CURLOPT_TIMEOUT]);
        }
    }

    public function testDownloadFileTimeout(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl, downloadFileTimeout: 2);

        $transport->get('getMe');

        $options = $curl->getOptions();
        assertNotNull($options);
        assertArrayNotHasKey(CURLOPT_TIMEOUT, $options);
    }

    public function testProxy(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl, proxy: 'socks5://user:password@127.0.0.1:1080');

        $transport->get('getMe');
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame('socks5://user:password@127.0.0.1:1080', $options[CURLOPT_PROXY]);

        $transport->post('//url/logOut', '', []);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame('socks5://user:password@127.0.0.1:1080', $options[CURLOPT_PROXY]);

        $transport->postWithFiles('//url/sendPhoto', [], []);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame('socks5://user:password@127.0.0.1:1080', $options[CURLOPT_PROXY]);

        $transport->longPoll('//url/getUpdates', 30);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame('socks5://user:password@127.0.0.1:1080', $options[CURLOPT_PROXY]);

        $transport->downloadFile('https://example.test/hello.jpg');
        $downloadOptions = $curl->getOptions();
        assertNotNull($downloadOptions);
        assertSame('socks5://user:password@127.0.0.1:1080', $downloadOptions[CURLOPT_PROXY]);
    }

    public function testWithoutProxy(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(curl: $curl);

        $transport->get('getMe');
        $options = $curl->getOptions();
        assertNotNull($options);
        assertArrayNotHasKey(CURLOPT_PROXY, $options);

        $transport->downloadFile('https://example.test/hello.jpg');
        $downloadOptions = $curl->getOptions();
        assertNotNull($downloadOptions);
        assertArrayNotHasKey(CURLOPT_PROXY, $downloadOptions);
    }

    public function testExtraCurlOptions(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(
            extraCurlOptions: [
                CURLOPT_HTTPHEADER => ['User-Agent: MyBot/1.0'],
                CURLOPT_CONNECTTIMEOUT => 5,
            ],
            curl: $curl,
        );

        $transport->get('getMe');
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(['User-Agent: MyBot/1.0'], $options[CURLOPT_HTTPHEADER]);
        assertSame(5, $options[CURLOPT_CONNECTTIMEOUT]);

        $transport->post('//url/logOut', '', ['Content-Type' => 'application/json; charset=utf-8']);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(['User-Agent: MyBot/1.0'], $options[CURLOPT_HTTPHEADER]);

        $transport->postWithFiles('//url/sendPhoto', [], []);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(['User-Agent: MyBot/1.0'], $options[CURLOPT_HTTPHEADER]);

        $transport->longPoll('//url/getUpdates', 30);
        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(['User-Agent: MyBot/1.0'], $options[CURLOPT_HTTPHEADER]);

        $transport->downloadFile('https://example.test/hello.jpg');
        $downloadOptions = $curl->getOptions();
        assertNotNull($downloadOptions);
        assertSame(['User-Agent: MyBot/1.0'], $downloadOptions[CURLOPT_HTTPHEADER]);
        assertSame(5, $downloadOptions[CURLOPT_CONNECTTIMEOUT]);
    }

    public function testExtraCurlOptionsPrecedence(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport(
            timeout: 2,
            extraCurlOptions: [CURLOPT_TIMEOUT => 5],
            curl: $curl,
        );

        $transport->get('getMe');

        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(5, $options[CURLOPT_TIMEOUT]);

        $transport->longPoll('getUpdates', 30);

        $options = $curl->getOptions();
        assertNotNull($options);
        assertSame(5, $options[CURLOPT_TIMEOUT]);
    }
}
