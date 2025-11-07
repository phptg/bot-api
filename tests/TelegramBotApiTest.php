<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests;

use HttpSoft\Message\StreamFactory;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Throwable;
use Phptg\BotApi\CustomMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\ApiResponse;
use Phptg\BotApi\FailResult;
use Phptg\BotApi\Method\GetMe;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Tests\Support\TransportMock;
use Phptg\BotApi\Type\AcceptedGiftTypes;
use Phptg\BotApi\Type\BotCommand;
use Phptg\BotApi\Type\BotDescription;
use Phptg\BotApi\Type\BotName;
use Phptg\BotApi\Type\BotShortDescription;
use Phptg\BotApi\Type\BusinessConnection;
use Phptg\BotApi\Type\ChatFullInfo;
use Phptg\BotApi\Type\ChatInviteLink;
use Phptg\BotApi\Type\ChatMemberMember;
use Phptg\BotApi\Type\ChatPermissions;
use Phptg\BotApi\Type\File;
use Phptg\BotApi\Type\ForumTopic;
use Phptg\BotApi\Type\Game\GameHighScore;
use Phptg\BotApi\Type\Inline\InlineQueryResultContact;
use Phptg\BotApi\Type\Inline\InlineQueryResultGame;
use Phptg\BotApi\Type\Inline\PreparedInlineMessage;
use Phptg\BotApi\Type\Inline\SentWebAppMessage;
use Phptg\BotApi\Type\InputChecklist;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputProfilePhotoStatic;
use Phptg\BotApi\Type\InputStoryContentPhoto;
use Phptg\BotApi\Type\MenuButtonDefault;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageId;
use Phptg\BotApi\Type\OwnedGifts;
use Phptg\BotApi\Type\Payment\StarTransactions;
use Phptg\BotApi\Type\StarAmount;
use Phptg\BotApi\Type\Sticker\Gifts;
use Phptg\BotApi\Type\Sticker\InputSticker;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\Story;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\UserChatBoosts;
use Phptg\BotApi\Type\UserProfilePhotos;
use Phptg\BotApi\Type\Update\Update;
use Phptg\BotApi\Type\Update\WebhookInfo;
use Yiisoft\Test\Support\Log\SimpleLogger;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class TelegramBotApiTest extends TestCase
{
    public function testWithLogger(): void
    {
        $logger1 = new SimpleLogger();
        $logger2 = new SimpleLogger();

        $api1 = new TelegramBotApi(
            'stub-token',
            transport: new TransportMock(
                new ApiResponse(200, '[]'),
            ),
            logger: $logger1,
        );
        $api2 = $api1->withLogger($logger2);

        try {
            $api2->call(new CustomMethod('getMe'));
        } catch (TelegramParseResultException) {
        }

        assertNotSame($api1, $api2);
        assertEmpty($logger1->getMessages());
        assertCount(2, $logger2->getMessages());
    }

    public function testCallSuccess(): void
    {
        $logger = new SimpleLogger();
        $method = new GetMe();
        $response = new ApiResponse(200, '{"ok":true,"result":{"id":1,"is_bot":false,"first_name":"Sergei"}}');
        $api = TestHelper::createSuccessStubApi($response, logger: $logger);

        $result = $api->call($method);

        assertInstanceOf(User::class, $result);
        assertSame(1, $result->id);

        $decodedResponse = [
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ];
        assertSame(
            [
                [
                    'level' => 'info',
                    'message' => 'Send GET-request "getMe".',
                    'context' => [
                        'type' => 1,
                        'payload' => [],
                        'method' => $method,
                    ],
                ],
                [
                    'level' => 'info',
                    'message' => 'On "getMe" request Telegram Bot API returned successful result.',
                    'context' => [
                        'type' => 2,
                        'payload' => $decodedResponse,
                        'method' => $method,
                        'response' => $response,
                        'decodedResponse' => $decodedResponse,
                    ],
                ],
            ],
            $logger->getMessages(),
        );
    }

    public function testCallSimpleMethod(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
        ]);

        $result = $api->call(new CustomMethod('getMe'));

        assertSame(
            [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            $result,
        );
    }

    #[TestWith([true])]
    #[TestWith([false])]
    public function testCallFail(bool $useLogger): void
    {
        $logger = $useLogger ? new SimpleLogger() : null;
        $method = new GetMe();
        $response = new ApiResponse(200, '{"ok":false,"description":"test error","error_code":400}');
        $api = TestHelper::createSuccessStubApi($response, logger: $logger);

        $result = $api->call($method);

        assertInstanceOf(FailResult::class, $result);
        assertSame('test error', $result->description);
        assertSame(400, $result->errorCode);

        if ($useLogger) {
            assertSame(
                [
                    [
                        'level' => 'info',
                        'message' => 'Send GET-request "getMe".',
                        'context' => [
                            'type' => 1,
                            'payload' => [],
                            'method' => $method,
                        ],
                    ],
                    [
                        'level' => 'warning',
                        'message' => 'On "getMe" request Telegram Bot API returned fail result.',
                        'context' => [
                            'type' => 3,
                            'payload' => '{"ok":false,"description":"test error","error_code":400}',
                            'method' => $method,
                            'response' => $response,
                            'decodedResponse' => [
                                'ok' => false,
                                'description' => 'test error',
                                'error_code' => 400,
                            ],
                        ],
                    ],
                ],
                $logger->getMessages(),
            );
        }
    }

    public function testCallFailWithInvalidDescription(): void
    {
        $method = new GetMe();
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, '{"ok":false,"description":5}'),
        );

        $result = $api->call($method);

        assertInstanceOf(FailResult::class, $result);
        assertNull($result->description);
    }

    public function testCallFailWithInvalidErrorCode(): void
    {
        $method = new GetMe();
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, '{"ok":false,"error_code":"2"}'),
        );

        $result = $api->call($method);

        assertInstanceOf(FailResult::class, $result);
        assertNull($result->errorCode);
    }

    public function testSuccessResponseWithoutResult(): void
    {
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, json_encode(['ok' => true])),
        );

        $exception = null;
        try {
            $api->call(new GetMe());
        } catch (Throwable $exception) {
        }
        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Not found "result" field in response. Status code: 200.', $exception->getMessage());
    }

    public function testResponseWithInvalidJson(): void
    {
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, 'g {12}'),
        );

        $exception = null;
        try {
            $api->call(new GetMe());
        } catch (Throwable $exception) {
        }
        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Failed to decode JSON response. Status code: 200.', $exception->getMessage());
    }

    #[TestWith([true])]
    #[TestWith([false])]
    public function testResponseWithInvalidResult(bool $useLogger): void
    {
        $logger = $useLogger ? new SimpleLogger() : null;
        $method = new GetMe();
        $api = TestHelper::createSuccessStubApi([], logger: $logger);

        $exception = null;
        try {
            $api->call($method);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Not found key "id" in result object.', $exception->getMessage());

        if ($useLogger) {
            assertSame(
                [
                    [
                        'level' => 'info',
                        'message' => 'Send GET-request "getMe".',
                        'context' => [
                            'type' => 1,
                            'payload' => [],
                            'method' => $method,
                        ],
                    ],
                    [
                        'level' => 'error',
                        'message' => 'Failed to parse telegram result. Not found key "id" in result object.',
                        'context' => [
                            'type' => 4,
                            'payload' => '{"ok":true,"result":[]}',
                        ],
                    ],
                ],
                $logger->getMessages(),
            );
        }
    }

    public function testNotArrayResponse(): void
    {
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, '"hello"'),
        );

        $exception = null;
        try {
            $api->call(new GetMe());
        } catch (Throwable $exception) {
        }

        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Expected telegram response as array. Got "string".', $exception->getMessage());
    }

    public function testResponseWithNotBooleanOk(): void
    {
        $api = TestHelper::createSuccessStubApi(
            new ApiResponse(200, json_encode(['ok' => 'true'])),
        );

        $exception = null;
        try {
            $api->call(new GetMe());
        } catch (Throwable $exception) {
        }

        assertInstanceOf(TelegramParseResultException::class, $exception);
        assertSame('Incorrect "ok" field in response. Status code: 200.', $exception->getMessage());
    }

    public function testMakeUrlPath(): void
    {
        $transport = new TransportMock();
        $api = new TelegramBotApi('stub-token', transport: $transport);

        $api->logout();

        assertSame('https://api.telegram.org/botstub-token/logOut', $transport->url());
    }

    public static function dataMakeFileUrl(): iterable
    {
        yield ['https://api.telegram.org/file/bot123/hello.png', new File('id', 'uid', filePath: 'hello.png')];
        yield ['https://api.telegram.org/file/bot123/face.jpg', 'face.jpg'];
    }

    #[DataProvider('dataMakeFileUrl')]
    public function testMakeFileUrl(string $expected, string|File $file): void
    {
        $api = new TelegramBotApi('123');

        $url = $api->makeFileUrl($file);
        self::assertSame($expected, $url);
    }

    public function testMakeFileUrlWithoutPath(): void
    {
        $api = new TelegramBotApi('123');
        $file = new File('id', 'uid');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The file path is not specified.');
        $api->makeFileUrl($file);
    }

    public function testDownloadFile(): void
    {
        $transport = new TransportMock();
        $api = new TelegramBotApi('xyz', transport: $transport);

        $result = $api->downloadFile('test.jpg');

        assertSame('https://api.telegram.org/file/botxyz/test.jpg', $result);
    }

    public function testDownloadFileTo(): void
    {
        $transport = new TransportMock();
        $api = new TelegramBotApi('xyz', transport: $transport);

        $api->downloadFileTo('test.jpg', 'path/to/my_file.jpg');

        assertSame(
            [
                ['https://api.telegram.org/file/botxyz/test.jpg', 'path/to/my_file.jpg'],
            ],
            $transport->savedFiles(),
        );
    }

    public function testAddStickerToSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->addStickerToSet(
            1,
            'test',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        assertTrue($result);
    }

    public function testAnswerCallbackQuery(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->answerCallbackQuery('id');

        assertTrue($result);
    }

    public function testAnswerInlineQuery(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->answerInlineQuery('id', []);

        assertTrue($result);
    }

    public function testAnswerPreCheckoutQuery(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->answerPreCheckoutQuery('id', true);

        assertTrue($result);
    }

    public function testAnswerShippingQuery(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->answerShippingQuery('id', true);

        assertTrue($result);
    }

    public function testAnswerWebAppQuery(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'inline_message_id' => 'idMessage',
        ]);

        $result = $api->answerWebAppQuery('id', new InlineQueryResultContact('1', '+79001234567', 'Vjik'));

        assertInstanceOf(SentWebAppMessage::class, $result);
        assertSame('idMessage', $result->inlineMessageId);
    }

    public function testApproveChatJoinRequest(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->approveChatJoinRequest(1, 2);

        assertTrue($result);
    }

    public function testApproveSuggestedPost(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->approveSuggestedPost(1, 2);

        assertTrue($result);
    }

    public function testBanChatMember(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->banChatMember(1, 2);

        assertTrue($result);
    }

    public function testBanChatSenderChat(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->banChatSenderChat(1, 2);

        assertTrue($result);
    }

    public function testClose(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->close();

        assertTrue($result);
    }

    public function testCloseForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->closeForumTopic(1, 2);

        assertTrue($result);
    }

    public function testCloseGeneralForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->closeGeneralForumTopic(1);

        assertTrue($result);
    }

    public function testConvertGiftToStars(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->convertGiftToStars('business_connection_id', 'owned_gift_id');

        assertTrue($result);
    }

    public function testCopyMessage(): void
    {
        $api = TestHelper::createSuccessStubApi(['message_id' => 7]);

        $result = $api->copyMessage(100, 200, 1);

        assertInstanceOf(MessageId::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testCopyMessages(): void
    {
        $api = TestHelper::createSuccessStubApi([
            ['message_id' => 7],
            ['message_id' => 8],
        ]);

        $result = $api->copyMessages(100, 200, [1, 2]);

        assertIsArray($result);
        assertCount(2, $result);
        assertInstanceOf(MessageId::class, $result[0]);
        assertInstanceOf(MessageId::class, $result[1]);
        assertSame(7, $result[0]->messageId);
        assertSame(8, $result[1]->messageId);
    }

    public function testCreateChatInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $result = $api->createChatInviteLink(1);

        assertInstanceOf(ChatInviteLink::class, $result);
        assertSame('https//t.me/+example', $result->inviteLink);
    }

    public function testCreateChatSubscriptionInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $result = $api->createChatSubscriptionInviteLink(10, 20, 30);

        assertInstanceOf(ChatInviteLink::class, $result);
        assertSame('https//t.me/+example', $result->inviteLink);
    }

    public function testCreateForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_thread_id' => 19,
            'name' => 'test',
            'icon_color' => 0x00FF00,
            'icon_custom_emoji_id' => '2351346235143',
        ]);

        $result = $api->createForumTopic(1, 'test');

        assertInstanceOf(ForumTopic::class, $result);
        assertSame(19, $result->messageThreadId);
    }

    public function testCreateInvoiceLink(): void
    {
        $api = TestHelper::createSuccessStubApi('https://example.com/invoice');

        $result = $api->createInvoiceLink(
            'The title',
            'The description',
            'The payload',
            'XTR',
            [],
        );

        assertSame('https://example.com/invoice', $result);
    }

    public function testCreateNewStickerSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->createNewStickerSet(1, 'test_by_bot', 'Test Pack', []);

        assertTrue($result);
    }

    public function testDeclineChatJoinRequest(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->declineChatJoinRequest(1, 2);

        assertTrue($result);
    }

    public function testDeclineSuggestedPost(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->declineSuggestedPost(1, 2);

        assertTrue($result);
    }

    public function testDeleteBusinessMessages(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteBusinessMessages('connection1', [123, 456]);

        assertTrue($result);
    }

    public function testDeleteChatPhoto(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteChatPhoto(1);

        assertTrue($result);
    }

    public function testDeleteChatStickerSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteChatStickerSet(1);

        assertTrue($result);
    }

    public function testDeleteForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteForumTopic(1, 2);

        assertTrue($result);
    }

    public function testDeleteMessage(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteMessage(1, 2);

        assertTrue($result);
    }

    public function testDeleteMessages(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteMessages(1, []);

        assertTrue($result);
    }

    public function testDeleteMyCommands(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteMyCommands();

        assertTrue($result);
    }

    public function testDeleteStickerFromSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteStickerFromSet('sid');

        assertTrue($result);
    }

    public function testDeleteStickerSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteStickerSet('test_by_bot');

        assertTrue($result);
    }

    public function testEditChatInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $result = $api->editChatInviteLink(1, 'https//t.me/+example');

        assertInstanceOf(ChatInviteLink::class, $result);
        assertSame(23, $result->creator->id);
    }

    public function testEditChatSubscriptionInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $result = $api->editChatSubscriptionInviteLink(1, 'https//t.me/+example');

        assertInstanceOf(ChatInviteLink::class, $result);
        assertSame(23, $result->creator->id);
    }

    public function testEditForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editForumTopic(1, 2);

        assertTrue($result);
    }

    public function testEditGeneralForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editGeneralForumTopic(1, 'test');

        assertTrue($result);
    }

    public function testEditMessageCaption(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editMessageCaption();

        assertTrue($result);
    }

    public function testEditMessageLiveLocation(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editMessageLiveLocation(51.660781, 39.200296);

        assertTrue($result);
    }

    public function testEditMessageMedia(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editMessageMedia(
            new InputMediaPhoto('https://example.com/photo.jpg'),
        );

        assertTrue($result);
    }

    public function testEditMessageChecklist(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->editMessageChecklist('bcid1', 23, 57, new InputChecklist('Title', []));

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testEditMessageReplyMarkup(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editMessageReplyMarkup();

        assertTrue($result);
    }

    public function testEditMessageText(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editMessageText('test');

        assertTrue($result);
    }

    public function testEditStory(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 23,
        ]);

        $result = $api->editStory(
            'business_connection_id',
            456,
            new InputStoryContentPhoto(
                new InputFile((new StreamFactory())->createStream()),
            ),
        );

        assertInstanceOf(Story::class, $result);
    }

    public function testEditUserStarSubscription(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->editUserStarSubscription(7, 'id', false);

        assertTrue($result);
    }

    public function testExportChatInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi('https//t.me/+example');

        $result = $api->exportChatInviteLink(1);

        assertSame('https//t.me/+example', $result);
    }

    public function testForwardMessage(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->forwardMessage(100, 200, 15);

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testForwardMessages(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
            ],
            [
                'message_id' => 8,
            ],
        ]);

        $result = $api->forwardMessages(100, 200, [1, 2]);

        assertIsArray($result);
        assertCount(2, $result);
        assertInstanceOf(MessageId::class, $result[0]);
        assertInstanceOf(MessageId::class, $result[1]);
        assertSame(7, $result[0]->messageId);
        assertSame(8, $result[1]->messageId);
    }

    public function testDeleteStory(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteStory('business_connection_id', 123);

        $this->assertTrue($result);
    }

    public function testDeleteWebhook(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->deleteWebhook();

        assertTrue($result);
    }

    public function testGetAvailableGifts(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'gifts' => [],
        ]);

        $result = $api->getAvailableGifts();

        assertInstanceOf(Gifts::class, $result);
    }

    public function testGetBusinessAccountGifts(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'total_count' => 0,
            'gifts' => [],
        ]);

        $result = $api->getBusinessAccountGifts('business_connection_id_123');

        assertInstanceOf(OwnedGifts::class, $result);
        assertEmpty($result->gifts);
    }

    public function testGetBusinessAccountStarBalance(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'amount' => 100,
        ]);

        $result = $api->getBusinessAccountStarBalance('business_connection_id_123');

        assertInstanceOf(StarAmount::class, $result);
        assertSame(100, $result->amount);
        assertNull($result->nanostarAmount);
    }

    public function testGetBusinessConnection(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => 'id1',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'user_chat_id' => 23,
            'date' => 1717517779,
            'rights' => [],
            'is_enabled' => false,
        ]);

        $result = $api->getBusinessConnection('b1');

        assertInstanceOf(BusinessConnection::class, $result);
        assertSame('id1', $result->id);
    }

    public function testGetChat(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
        ]);

        $result = $api->getChat(23);

        assertInstanceOf(ChatFullInfo::class, $result);
        assertSame(23, $result->id);
    }

    public function testGetChatAdministrators(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'status' => 'member',
                'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
            ],
        ]);

        $result = $api->getChatAdministrators(23);

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(ChatMemberMember::class, $result[0]);
        assertSame(23, $result[0]->user->id);
    }

    public function testGetChatMemberCount(): void
    {
        $api = TestHelper::createSuccessStubApi(33);

        $result = $api->getChatMemberCount(1);

        assertSame(33, $result);
    }

    public function testGetChatMember(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'status' => 'member',
            'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
        ]);

        $result = $api->getChatMember(1, 2);

        assertInstanceOf(ChatMemberMember::class, $result);
        assertSame(23, $result->user->id);
    }

    public function testGetChatMenuButton(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'type' => 'default',
        ]);

        $result = $api->getChatMenuButton();

        assertInstanceOf(MenuButtonDefault::class, $result);
    }

    public function testGetFile(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'file_id' => 'f1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ]);

        $result = $api->getFile('f1');

        assertInstanceOf(File::class, $result);
        assertSame('f1', $result->fileId);
    }

    public function testGetForumTopicIconStickers(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
        ]);

        $result = $api->getForumTopicIconStickers();

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(Sticker::class, $result[0]);
        assertSame('x1', $result[0]->fileId);
    }

    public function testGetGameHighScores(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'position' => 2,
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'test',
                ],
                'score' => 300,
            ],
        ]);

        $result = $api->getGameHighScores(1);

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(GameHighScore::class, $result[0]);
        assertSame(2, $result[0]->position);
    }

    public function testGetCustomEmojiStickers(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
        ]);

        $result = $api->getCustomEmojiStickers(['id1']);

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(Sticker::class, $result[0]);
        assertSame('x1', $result[0]->fileId);
    }

    public function testGetMe(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
        ]);

        $result = $api->getMe();

        assertInstanceOf(User::class, $result);
        assertSame(1, $result->id);
    }

    public function testGetMyCommands(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'command' => 'start',
                'description' => 'Start command',
            ],
        ]);

        $result = $api->getMyCommands();

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(BotCommand::class, $result[0]);
        assertSame('start', $result[0]->command);
    }

    public function testGetMyDefaultAdministratorRights(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'is_anonymous' => true,
            'can_manage_chat' => false,
            'can_delete_messages' => true,
            'can_manage_video_chats' => true,
            'can_restrict_members' => false,
            'can_promote_members' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_post_stories' => true,
            'can_edit_stories' => true,
            'can_delete_stories' => false,
            'can_post_messages' => true,
            'can_edit_messages' => true,
            'can_pin_messages' => false,
            'can_manage_topics' => true,
        ]);

        $result = $api->getMyDefaultAdministratorRights();

        assertTrue($result->isAnonymous);
        assertFalse($result->canManageChat);
        assertTrue($result->canDeleteMessages);
        assertTrue($result->canManageVideoChats);
        assertFalse($result->canRestrictMembers);
        assertTrue($result->canPromoteMembers);
        assertTrue($result->canChangeInfo);
        assertTrue($result->canInviteUsers);
        assertTrue($result->canPostStories);
        assertTrue($result->canEditStories);
        assertFalse($result->canDeleteStories);
        assertTrue($result->canPostMessages);
        assertTrue($result->canEditMessages);
        assertFalse($result->canPinMessages);
        assertTrue($result->canManageTopics);
    }

    public function testGetMyDescription(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'description' => 'test',
        ]);

        $result = $api->getMyDescription();

        assertInstanceOf(BotDescription::class, $result);
        assertSame('test', $result->description);
    }

    public function testGetMyName(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'name' => 'test',
        ]);

        $result = $api->getMyName();

        assertInstanceOf(BotName::class, $result);
        assertSame('test', $result->name);
    }

    public function testGetMyShortDescription(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'short_description' => 'test',
        ]);

        $result = $api->getMyShortDescription();

        assertInstanceOf(BotShortDescription::class, $result);
        assertSame('test', $result->shortDescription);
    }

    public function testGetMyStarBalance(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'amount' => 7,
        ]);

        $result = $api->getMyStarBalance();

        assertInstanceOf(StarAmount::class, $result);
        assertSame(7, $result->amount);
    }

    public function testGetStarTransactions(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'transactions' => [],
        ]);

        $result = $api->getStarTransactions();

        assertInstanceOf(StarTransactions::class, $result);
    }

    public function testGetStickerSet(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'name' => 'test_by_bot',
            'title' => 'test name',
            'sticker_type' => 'regular',
            'stickers' => [
                [
                    'file_id' => 'fid1',
                    'file_unique_id' => 'fuid1',
                    'type' => 'regular',
                    'width' => 200,
                    'height' => 300,
                    'is_animated' => false,
                    'is_video' => false,
                ],
            ],
        ]);

        $result = $api->getStickerSet('test_by_bot');

        assertSame('test name', $result->title);
    }

    public function testGetUpdates(): void
    {
        $api = TestHelper::createSuccessStubApi([
            ['update_id' => 1],
            ['update_id' => 2],
        ]);

        $result = $api->getUpdates();

        assertIsArray($result);
        assertCount(2, $result);
        assertInstanceOf(Update::class, $result[0]);
        assertInstanceOf(Update::class, $result[1]);
        assertSame(1, $result[0]->updateId);
        assertSame(2, $result[1]->updateId);
    }

    public function testGetMethodWithParams(): void
    {
        $transport = TransportMock::successResult([]);
        $api = new TelegramBotApi('stub-token', transport: $transport);

        $api->getUpdates(offset: 5, allowedUpdates: ['message', 'edited_message', 'channel_post']);

        assertSame(
            'https://api.telegram.org/botstub-token/getUpdates?offset=5&allowed_updates=%5B%22message%22%2C%22edited_message%22%2C%22channel_post%22%5D',
            $transport->url(),
        );
    }

    public function testPostMethodWithParams(): void
    {
        $transport = TransportMock::successResult([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);
        $api = new TelegramBotApi('stub-token', transport: $transport);

        $api->sendMessage('id1', 'hello');

        assertSame(
            'https://api.telegram.org/botstub-token/sendMessage',
            $transport->url(),
        );
        assertSame(
            '{"chat_id":"id1","text":"hello"}',
            $transport->sentBody(),
        );
        assertSame(
            [
                'Content-Length' => '32',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
            $transport->sentHeaders(),
        );
    }

    public function testPostMethodWithFiles(): void
    {
        $transport = TransportMock::successResult([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);
        $api = new TelegramBotApi('stub-token', transport: $transport);

        $file =  new InputFile(
            (new StreamFactory())->createStream('test1'),
        );
        $api->sendDocument('id1', $file);

        assertSame(
            'https://api.telegram.org/botstub-token/sendDocument',
            $transport->url(),
        );
        assertSame(
            ['chat_id' => 'id1'],
            $transport->sentData(),
        );
        assertSame(
            ['document' => $file],
            $transport->sentFiles(),
        );
    }

    public function testGetUserChatBoosts(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'boosts' => [],
        ]);

        $result = $api->getUserChatBoosts(1, 2);

        assertInstanceOf(UserChatBoosts::class, $result);
    }

    public function testGetUserProfilePhotos(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'total_count' => 1,
            'photos' => [
                [
                    [
                        'file_id' => 'f1',
                        'file_unique_id' => 'fullX1',
                        'file_size' => 123,
                        'width' => 100,
                        'height' => 200,
                    ],
                ],
            ],
        ]);

        $result = $api->getUserProfilePhotos(7);

        assertInstanceOf(UserProfilePhotos::class, $result);
    }

    public function testGetWebhookInfo(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'url' => 'https://example.com/',
            'has_custom_certificate' => true,
            'pending_update_count' => 12,
        ]);

        $result = $api->getWebhookInfo();

        assertInstanceOf(WebhookInfo::class, $result);
        assertSame('https://example.com/', $result->url);
    }

    public function testGiftPremiumSubscription(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->giftPremiumSubscription(123456789, 3, 1000);

        $this->assertTrue($result);
    }

    public function testHideGeneralForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->hideGeneralForumTopic(1);

        assertTrue($result);
    }

    public function testLeaveChat(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->leaveChat(1);

        assertTrue($result);
    }

    public function testLogOut(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->logOut();

        assertTrue($result);
    }

    public function testPinChatMessage(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->pinChatMessage(1, 2);

        assertTrue($result);
    }

    public function testPostStory(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 23,
        ]);

        $result = $api->postStory(
            'business_connection_id',
            new InputStoryContentPhoto(
                new InputFile((new StreamFactory())->createStream()),
            ),
            86400,
        );

        assertInstanceOf(Story::class, $result);
    }

    public function testPromoteChatMember(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->promoteChatMember(1, 2);

        assertTrue($result);
    }

    public function testReadBusinessMessage(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->readBusinessMessage('bid1', 25, 146);

        assertTrue($result);
    }

    public function testRefundStarPayment(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->refundStarPayment(1, 'test');

        assertTrue($result);
    }

    public function testRemoveBusinessAccountProfilePhoto(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->removeBusinessAccountProfilePhoto('connection1');

        assertTrue($result);
    }

    public function testRemoveChatVerification(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->removeChatVerification(1);

        assertTrue($result);
    }

    public function testRemoveUserVerification(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->removeUserVerification(1);

        assertTrue($result);
    }

    public function testReopenForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->reopenForumTopic(1, 2);

        assertTrue($result);
    }

    public function testReopenGeneralForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->reopenGeneralForumTopic(1);

        assertTrue($result);
    }

    public function testReplaceStickerInSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->replaceStickerInSet(
            1,
            'test',
            'oldid',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        assertTrue($result);
    }

    public function testRestrictChatMember(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->restrictChatMember(1, 2, new ChatPermissions());

        assertTrue($result);
    }

    public function testRevokeChatInviteLink(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $result = $api->revokeChatInviteLink(1, 'https//t.me/+example');

        assertInstanceOf(ChatInviteLink::class, $result);
        assertSame(23, $result->creator->id);
    }

    public function testSavePreparedInlineMessage(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => 'test-id',
            'expiration_date' => 1620000000,
        ]);

        $result = $api->savePreparedInlineMessage(12, new InlineQueryResultGame('test', 'Hello'));

        assertInstanceOf(PreparedInlineMessage::class, $result);
        assertSame('test-id', $result->id);
    }

    public function testSetBusinessAccountBio(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setBusinessAccountBio('connection1');

        assertTrue($result);
    }

    public function testSetBusinessAccountGiftSettings(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setBusinessAccountGiftSettings(
            'connection1',
            true,
            new AcceptedGiftTypes(true, true, true, false),
        );

        assertTrue($result);
    }

    public function testSetBusinessAccountName(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setBusinessAccountName('connection1', 'John', 'Doe');

        assertTrue($result);
    }

    public function testSetBusinessAccountProfilePhoto(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setBusinessAccountProfilePhoto(
            'biz123',
            new InputProfilePhotoStatic(
                new InputFile((new StreamFactory())->createStream()),
            ),
        );

        assertTrue($result);
    }

    public function testSetBusinessAccountUsername(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setBusinessAccountUsername('connection1', 'test_name');

        assertTrue($result);
    }

    public function testSendAnimation(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendAnimation(12, 'https://example.com/anime.gif');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendAudio(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendAudio(12, 'https://example.com/audio.mp3');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendChatAction(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->sendChatAction(12, 'typing');

        assertTrue($result);
    }

    public function testSendContact(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendContact(12, '1234567890', 'John');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendChecklist(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendChecklist('bcid1', 23, new InputChecklist('Title', []));

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendDice(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendDice(12);

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendDocument(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendDocument(12, 'https://example.com/file.doc');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendGame(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendGame(12, 'The Stars');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendGift(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->sendGift(12, 'gid');

        assertTrue($result);
    }

    public function testSendInvoice(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendInvoice(
            1,
            'The title',
            'The description',
            'The payload',
            'XTR',
            [],
        );

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendLocation(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendLocation(12, 1.1, 2.2);

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendMediaGroup(): void
    {
        $api = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendMediaGroup(12, []);

        assertIsArray($result);
        assertCount(1, $result);
        assertInstanceOf(Message::class, $result[0]);
        assertSame(7, $result[0]->messageId);
    }

    public function testSendMessage(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendMessage(12, 'hello');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendPaidMedia(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendPaidMedia(12, 25, []);

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendPhoto(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendPhoto(12, 'https://example.com/i.png');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendPoll(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendPoll(12, 'How are you?', []);

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendSticker(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendSticker(12, 'https://example.com/sticker.webp');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendVenue(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendVenue(12, 1.1, 2.2, 'title', 'address');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendVideo(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendVideo(12, 'https://example.com/wow.mp4');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }


    public function testSendVideoNote(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendVideoNote(12, 'https://example.com/wow.mp4');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSendVoice(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $result = $api->sendVoice(12, 'https://example.com/wow.mp3');

        assertInstanceOf(Message::class, $result);
        assertSame(7, $result->messageId);
    }

    public function testSetChatAdministratorCustomTitle(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatAdministratorCustomTitle(1, 2, 'test');

        assertTrue($result);
    }

    public function testSetChatPermissions(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatPermissions(1, new ChatPermissions());

        assertTrue($result);
    }

    public function testSetChatDescription(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatDescription(12);

        assertTrue($result);
    }

    public function testSetChatMenuButton(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatMenuButton();

        assertTrue($result);
    }

    public function testSetChatPhoto(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatPhoto(12, new InputFile((new StreamFactory())->createStream()));

        assertTrue($result);
    }

    public function testSetChatStickerSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatStickerSet(1, 'animals_by_bot');

        assertTrue($result);
    }

    public function testSetChatTitle(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setChatTitle(12, 'test');

        assertTrue($result);
    }

    public function testSetCustomEmojiStickerSetThumbnail(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setCustomEmojiStickerSetThumbnail('animals_by_my_bor');

        assertTrue($result);
    }

    public function testSetGameScore(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setGameScore(1, 2);

        assertTrue($result);
    }

    public function testSetMessageReaction(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMessageReaction(12, 270);

        assertTrue($result);
    }

    public function testSetMyCommands(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMyCommands([
            new BotCommand('test', 'Test description'),
        ]);

        assertTrue($result);
    }

    public function testSetMyDefaultAdministratorRights(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMyDefaultAdministratorRights();

        assertTrue($result);
    }

    public function testSetMyDescription(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMyDescription();

        assertTrue($result);
    }

    public function testSetMyName(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMyName();

        assertTrue($result);
    }

    public function testSetMyShortDescription(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setMyShortDescription();

        assertTrue($result);
    }

    public function testSetPassportDataErrors(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setPassportDataErrors(1, []);

        assertTrue($result);
    }

    public function testSetStickerEmojiList(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerEmojiList('sid', ['😎']);

        assertTrue($result);
    }

    public function testSetStickerKeywords(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerKeywords('sid');

        assertTrue($result);
    }

    public function testSetStickerMaskPosition(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerMaskPosition('sid');

        assertTrue($result);
    }

    public function testSetStickerPositionInSet(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerPositionInSet('sid', 2);

        assertTrue($result);
    }

    public function testSetStickerSetThumbnail(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerSetThumbnail('animals_by_boy', 123, 'static');

        assertTrue($result);
    }

    public function testSetStickerSetTitle(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setStickerSetTitle('name_by_bot', 'New Title');

        assertTrue($result);
    }

    public function testSetUserEmojiStatus(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setUserEmojiStatus(19);

        assertTrue($result);
    }

    public function testSetWebhook(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->setWebhook('https://example.com/webhook');

        assertTrue($result);
    }

    public function testStopMessageLiveLocation(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->stopMessageLiveLocation();

        assertTrue($result);
    }

    public function testStopPoll(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'id' => '12',
            'question' => 'Why?',
            'options' => [
                ['text' => 'One', 'voter_count' => 12],
            ],
            'total_voter_count' => 42,
            'is_closed' => true,
            'is_anonymous' => false,
            'type' => 'regular',
            'allows_multiple_answers' => true,
        ]);

        $result = $api->stopPoll(1, 2);

        assertSame('12', $result->id);
    }

    public function testTransferBusinessAccountStars(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->transferBusinessAccountStars('connection1', 100);

        assertTrue($result);
    }

    public function testTransferGift(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->transferGift(
            'business_connection_id',
            'owned_gift_id',
            123456789,
        );

        assertTrue($result);
    }

    public function testUnbanChatMember(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unbanChatMember(1, 2);

        assertTrue($result);
    }

    public function testUnbanChatSenderChat(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unbanChatSenderChat(1, 2);

        assertTrue($result);
    }

    public function testUnhideGeneralForumTopic(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unhideGeneralForumTopic(1);

        assertTrue($result);
    }

    public function testUnpinAllChatMessages(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unpinAllChatMessages(2);

        assertTrue($result);
    }

    public function testUnpinChatMessage(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unpinChatMessage(2);

        assertTrue($result);
    }

    public function testUnpinAllForumTopicMessages(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unpinAllForumTopicMessages(1, 2);

        assertTrue($result);
    }

    public function testUnpinAllGeneralForumTopicMessages(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->unpinAllGeneralForumTopicMessages(2);

        assertTrue($result);
    }

    public function testUpgradeGift(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->upgradeGift('business_connection_id', 'owned_gift_id');

        assertTrue($result);
    }

    public function testUploadStickerFile(): void
    {
        $api = TestHelper::createSuccessStubApi([
            'file_id' => 'f1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ]);

        $result = $api->uploadStickerFile(1, new InputFile((new StreamFactory())->createStream()), 'static');

        assertInstanceOf(File::class, $result);
        assertSame('f1', $result->fileId);
    }

    public function testVerifyChat(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->verifyChat(1);

        assertTrue($result);
    }

    public function testVerifyUser(): void
    {
        $api = TestHelper::createSuccessStubApi(true);

        $result = $api->verifyUser(1);

        assertTrue($result);
    }
}
