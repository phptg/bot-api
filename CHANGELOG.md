# Telegram Bot API for PHP Change Log

## 0.15 under development

- Chg #186: Remove `PsrTransport`, `PsrWebhookResponseFactory` and `StreamResourceReader` classes.
- Chg #186: Remove `Update::fromServerRequest()` method.
- Chg #186: Remove PSR composer dependencies.
## 0.14.1 February 9, 2026

- New #186: Add `SetMyProfilePhoto`, `RemoveMyProfilePhoto` and `GetUserProfileAudios` methods.
- New #186: Add `ChatOwnerLeft`, `ChatOwnerChanged`, `VideoQuality` and `UserProfileAudios` types.
- New #186: Add `allowsUsersToCreateTopics` field to `User` type.
- New #186: Add `iconCustomEmojiId` and `style` fields to `KeyboardButton` type.
- New #186: Add `iconCustomEmojiId` and `style` fields to `InlineKeyboardButton` type.
- New #186: Add `chatOwnerLeft` and `chatOwnerChanged` fields to `Message` type.
- New #186: Add `qualities` field to `Video` type.
- New #186: Add `firstProfileAudio` field to `ChatFullInfo` type.
- New #186: Add `rarity` field to `UniqueGiftModel` type.
- New #186: Add `isBurned` field to `UniqueGift` type.

## 0.14 February 7, 2026

- New #182: Introduce resource readers that handle reading content from different types of resources stored in
  `InputFile`. Add `ResourceReaderInterface` and built-in implementations: `NativeResourceReader` for native PHP
  resources and `StreamResourceReader` for PSR-7 streams.
- New #182: Add `resourceReaders` constructor parameter to `CurlTransport` and `NativeTransport`.
- Chg #182: Change `MimeTypeResolverInterface::resolve()` signature to accept `InputFileData` instead of `InputFile`.
- Chg #183: Change `$mimeTypeResolver` parameter in `NativeTransport` constructor from nullable to non-nullable.

## 0.13.0 January 18, 2026

- Bug #180: Make `rights` property optional in `BusinessConnection` type.
- Chg #180: Change order of `BusinessConnection` constructor parameters.

## 0.12.0 January 1, 2026

- New #177: Add `hasTopicsEnabled` field to `User` type.
- New #177: Add `isNameImplicit` field to `ForumTopic` and `ForumTopicCreated` types.
- New #177: Add `giftUpgradeSent` field to `Message` type.
- New #177: Add `giftId`, `isPremium`, `isFromBlockchain` and `colors` fields to `UniqueGift` type.
- New #177: Add `isPremium`, `hasColors`, `personalTotalCount`, `personalRemainingCount`, `background` and
  `uniqueGiftVariantCount` fields to `Gift` type.
- New #177: Add `isUpgradeSeparate` and `uniqueGiftNumber` fields to `GiftInfo` and `OwnedGiftRegular` types.
- New #177: Add `giftsFromChannels` field to `AcceptedGiftTypes` type.
- New #177: Add `rating`, `uniqueGiftColors` and `paidMessageStarCount` fields to `ChatFullInfo` type.
- New #177: Add `UniqueGiftColors`, `GiftBackground` and `UserRating` types.
- New #177: Add `SendMessageDraft`, `getUserGifts`, `getChatGifts` and `repostStory` methods.
- New #177: Add `excludeFromBlockchain` parameter to `getBusinessAccountGifts` method.
- New #177: Add `messageEffectId` parameter to `forwardMessage` and `copyMessage` methods.
- New #177: Add `completedByChat` field to `ChecklistTask` type.
- Chg #177: Replace `lastResaleStarCount` field with `lastResaleCurrency` and `lastResaleAmount` fields in
  `UniqueGiftInfo` type.
- Chg #177: Replace `excludeLimited` parameter with `excludeLimitedUpgradable` and `excludeLimitedNonUpgradable`
  parameters in `getBusinessAccountGifts` method.

## 0.11.0 December 29, 2025

- Chg #171: Simplify `TransportInterface` implementations by replacing single `send()` method with specific methods:
  `get()`, `post()`, and `postWithFiles()`.
- Chg #175: Change PHP constraint in `composer.json` to `8.2 - 8.5`.

## 0.10.0 November 1, 2025

- Chg #172: Rename package from `vjik/telegram-bot-api` to `phptg/bot-api` and change namespace
  `Vjik\TelegramBot\Api` to `Phptg\BotApi`.
- Enh #170: Improve `CurlTransport` performance by sharing data between cURL handles.

## 0.9.3 October 22, 2025

- New #167: Add `WebhookResponse` class that represents method as response on webhook.
- New #167: Add webhook response factories `PsrWebhookResponseFactory` and `JsonWebhookResponseFactory`.

## 0.9.2 August 16, 2025

- New #164: Add `checklistTaskId` field to `ReplyParameters` type.
- New #164: Add `publisherChat` field to `Gift` and `UniqueGift` types.
- New #164: Add `isDirectMessages` field to `Chat` and `ChatFullInfo` types.
- New #164: Add `parentChat` field to `ChatFullInfo` type.
- New #164: Add `directMessagesTopicId` parameter to `sendMessage`, `sendPhoto`, `sendVideo`, `sendAnimation`,
  `sendAudio`, `sendDocument`, `sendPaidMedia`, `sendSticker`, `sendVideoNote`, `sendVoice`, `sendLocation`, 
  `sendVenue`, `sendContact`, `sendDice`, `sendInvoice`, `sendMediaGroup`, `copyMessage`, `copyMessages`, 
  `forwardMessage` and `forwardMessages` methods.
- New #164: Add `suggestedPostParameters` parameter to `sendMessage`, `sendPhoto`, `sendVideo`, `sendAnimation`,
  `sendAudio`, `sendDocument`, `sendPaidMedia`, `sendSticker`, `sendVideoNote`, `sendVoice`, `sendLocation`,
  `sendVenue`, `sendContact`, `sendDice`, `sendInvoice`, `copyMessage` and `forwardMessage` methods.
- New #164: Add `messageThreadId` parameter to `SendPaidMedia` method.
- New #164: Add `approveSuggestedPost` and `declineSuggestedPost` methods.
- New #164: Add `canManageDirectMessages` field to `ChatMemberAdministrator` and `ChatAdministratorRights` types.
- New #164: Add `canManageDirectMessages` parameter to `promoteChatMember` method.
- New #164: Add `DirectMessagesTopic`, `SuggestedPostPrice`, `SuggestedPostParameters`, `SuggestedPostInfo`,
  `SuggestedPostApproved`, `SuggestedPostApprovalFailed`, `SuggestedPostDeclined`, `SuggestedPostPaid` and 
  `SuggestedPostRefunded` types.
- New #164: Add `replyToChecklistTaskId`, `directMessagesTopic`, `isPaidPost`, `suggestedPostInfo`,
  `suggestedPostApproved`, `suggestedPostApprovalFailed`, `suggestedPostDeclined`, `suggestedPostPaid` and 
  `suggestedPostRefunded` fields to `Message` type.

## 0.9.1 July 4, 2025

- Chg #160: Change PHP constraint in `composer.json` from `php` to `php-64bit`.
- New #155: Add `NativeTransport` that used native `file_get_contents()` and `file_put_contents()` functions.
- New #162: Add `ChecklistTask`, `Checklist`, `InputChecklistTask`, `InputChecklist`, `ChecklistTasksDone`,
  `ChecklistTasksAdded` and `DirectMessagePriceChanged` types.
- New #162: Add `checklist`, `checklistTasksDone`, `checklistTasksAdded` and `directMessagePriceChanged` fields to
  `Message` type.
- New #162: Add `checklist` field to `ExternalReplyInfo` type.
- New #162: Add `sendChecklist`, `editMessageChecklist` and `getMyStarBalance` methods.
- New #162: Add `nextTransferDate` field to `OwnedGiftUnique` type.
- New #162: Add `nextTransferDate` and `lastResaleStarCount` fields to `UniqueGiftInfo` type.

## 0.9.0 April 12, 2025

- New #152: Add `downloadFile()` and `downloadFileTo()` methods to `TelegramBotApi`.
- New #156: Add `AcceptedGiftTypes`, `BusinessBotRights`, `GiftInfo`, `InputProfilePhotoAnimated`,
  `InputProfilePhotoStatic`, `InputProfilePhoto`, `InputStoryContentPhoto`, `InputStoryContentVideo`,
  `InputStoryContent`, `LocationAddress`, `OwnedGiftRegular`, `OwnedGiftUnique`, `OwnedGift`, `OwnedGifts`,
  `PaidMessagePriceChanged`, `StarAmount`, `StoryAreaPosition`, `StoryAreaTypeLink`, `StoryAreaTypeLocation`,
  `StoryAreaTypeSuggestedReaction`, `StoryAreaTypeUniqueGift`, `StoryAreaTypeWeather`, `StoryAreaType`, `StoryArea`,
  `UniqueGiftBackdropColors`, `UniqueGiftBackdrop`, `UniqueGiftInfo`, `UniqueGiftModel`, `UniqueGiftSymbol` and
  `UniqueGift` types.
- New #156: Add `DeleteStory`, `GetBusinessAccountGifts`, `ConvertGiftToStars`, `UpgradeGift`, `TransferGift`,
  `PostStory`, `EditStory`, `GiftPremiumSubscription`, `ReadBusinessMessage`, `DeleteBusinessMessages`,
  `SetBusinessAccountName`, `SetBusinessAccountUsername`, `SetBusinessAccountBio`, `SetBusinessAccountProfilePhoto`,
  `RemoveBusinessAccountProfilePhoto`, `SetBusinessAccountGiftSettings`, `GetBusinessAccountStarBalance` and
  `TransferBusinessAccountStars` methods.
- New #156: Add `paidMessagePriceChanged`, `paidStarCount`, `gift` and `uniqueGift` fields to `Message` type.
- New #156: Add `premiumSubscriptionDuration` and `transactionType` fields to `TransactionPartnerUser` type.
- Chg #152: Add `downloadFile()` and `downloadFileTo()` methods to `TransportInterface`.
- Chg #152: Move `CurlTransport` from `Vjik\TelegramBot\Api\Transport\Curl` to `Vjik\TelegramBot\Api\Transport`.
- Chg #154: `TelegramBotApi::makeFileUrl()` always returns a string and throw `LogicException` if the file path is not
  specified in `File` object.
- Chg #156: In `BusinessConnection` type replace `canReply` field with `rights` field of `BusinessBotRights` type.
- Chg #156: In `ChatFullInfo` type replace `canSendGift` field with `acceptedGiftTypes` field.
- Enh #151: Add `SensitiveParameter` attribute to token parameters in `TelegramBotApi` methods.

## 0.8.0 February 15, 2025

- New #148: Add `TelegramBotApi::makeFileUrl()` method.
- Chg #145: Remove `ApiUrlGenerator`.
- Chg #145: Move `$token` and `$baseUrl` parameters from transport classes (`CurlTransport`, `PsrTransport`) to
  `TelegramBotApi`.
- Chg #145: Change `$apiMethod` parameter to `$urlPath` in `TransportInterface::send()` method.
- Enh #145: Make `$transport` in `TelegramBotApi` optional (cURL transport will be used by default).
- Enh #147: Use `SensitiveParameter` attribute to mark sensitive parameters.

## 0.7.1 February 12, 2025

- New #142: Add `CurlTransport`.
- New #144: Add `chatId` parameter to `SendGift` method.
- New #144: Add `canSendGift` field to `ChatFullInfo` type.
- New #144: Add `TransactionPartnerChat` type.
- New #144: Add `cover` and `startTimestamp` fields to `Video`, `InputMediaVideo` and `InputPaidMediaVideo` types.
- New #144: Add `cover` and `startTimestamp` parameters to `SendVideo` method.
- New #144: Add `videoStartTimestamp` parameter to `ForwardMessage` and `CopyMessage` methods.

## 0.7.0 February 10, 2025

- New #139: Add `RawValue` value processor.
- Chg #139: Change result of `MethodInterface::getResultType()` to `ValueProcessorInterface`.
- Chg #143: Change `FailResult::$errorCode` type to `int|null`.
- Enh #140: Extract core code from `TelegramBotApi` to internal `Api` class.
- Enh #136: Minor refactoring of `ObjectFactory` class.
- Enh #138: Remove unused private properties in `PsrTransport` class.

## 0.6.0 January 24, 2025

- Chg #132: Rename definitions "telegram client" to "transport", "telegram response" to "api response" and
  "telegram request" to "method". Classes, namespaces, and variables rename accordingly.
- Chg #132: Remove `TelegramRequest`.
- Chg #132: Rename `TelegramClientInterface` to `TransportInterface` and change `send()` method signature.
- Chg #132: Rename `TelegramRequestWithResultPreparingInterface` to `MethodInterface`.
- Chg #132: Rename `RequestFileCollector` to `FileCollector` and move to root namespace.
- Chg #132: Rename `TelegramBotApi::send()` method to `call()`.
- Chg #133: Remove JSON encoding of payload in log contexts.
- Chg #133: Extract log context creating methods to separated internal class.
- Enh #134: Remove dead code.

## 0.5.0 January 02, 2025

- New #129: Add `verifyUser`, `verifyChat`, `removeUserVerification` and `removeChatVerification` methods.
- New #129: Add `upgradeStarCount` field to `Gift` type.
- New #129: Add `payForUpgrade` parameter to `SendGift` method.
- Chg #129: Remove `hideUrl` field from `InlineQueryResultArticle` type.

## 0.4.7.1 December 18, 2024

- Bug #128: Add a check for a seekable response body and rewind in `PsrTelegramClient`.

## 0.4.7 December 04, 2024

- New #126: Add `nanostarAmount` field to `StarTransaction` type.
- New #126: Add `TransactionPartnerAffiliateProgram` type.
- New #126: Add `AffiliateInfo` type.
- New #126: Add `affiliate` field to `TransactionPartnerUser` type.

## 0.4.6 November 18, 2024

- New #125: Add `subscriptionPeriod` and `businessConnectionId` parameters to `createInvoiceLink` method.
- New #125: Add `subscriptionExpirationDate`, `isRecurring` and `isFirstRecurring` fields to `SuccessfulPayment` type.
- New #125: Add `editUserStarSubscription` method.
- New #125: Add `subscriptionPeriod` and `gift` fields to `TransactionPartnerUser` type.
- New #125: Add `setUserEmojiStatus` method.
- New #125: Add `PreparedInlineMessage` type.
- New #125: Add `savePreparedInlineMessage` method.
- New #125: Add `Gift` and `Gifts` types.
- New #125: Add `getAvailableGifts` and `SendGift` methods.

## 0.4.5 October 31, 2024

- New #124: Add `CopyTextButton` type.
- New #124: Add `copyText` field to `InlineKeyboardButton` type.
- New #124: Add `allowPaidBroadcast` field to `sendMessage`, `sendPhoto`, `sendVideo`, `sendAnimation`, `sendAudio`,
  `sendDocument`, `sendPaidMedia`, `sendSticker`, `sendVideoNote`, `sendVoice`, `sendLocation`, `sendVenue`,
  `sendContact`, `sendPoll`, `sendDice`, `sendInvoice`, `sendGame`, `sendMediaGroup` and `copyMessage` methods.
- New #124: Add `TransactionPartnerTelegramApi` type.
- Bug #124: Rename `PaidMediaPurchased` property `payload` to `paidMediaPayload`.

## 0.4.4 October 26, 2024

- Enh #119: Use fully qualified function calls to improve performance.
- Enh #119: Use more specific psalm annotations.
- Bug #121: Rename `PaidMediaPurchased` property `paidMediaPayload` to `payload`.

## 0.4.3 September 06, 2024

- New #118: Add `PaidMediaPurchased` type.
- New #118: Add `purchasedPaidMedia` field to `Update` type.
- New #118: Add `paidMediaPayload` field to `TransactionPartnerUser` type.
- New #118: Add `payload` parameter to `SendPaidMedia` method.
- New #118: Add `prizeStarCount ` field to `GiveawayCreated`, `Giveaway`, `GiveawayWinners` and
  `ChatBoostSourceGiveaway` types.
- New #118: Add `isStarGiveaway` field to `GiveawayCompleted` type.
- Enh #118: Bump `php-http/multipart-stream-builder` dependency to `^1.4.2` version.

## 0.4.2 August 22, 2024

- New #117: Add `createChatSubscriptionInviteLink` and `editChatSubscriptionInviteLink` methods.
- New #117: Add `businessConnectionId` parameter to `SendPaidMedia` method.
- New #117: Add `ReactionTypePaid` type.
- New #117: Add `paidMedia` field to `TransactionPartnerUser` type.
- New #117: Add `subscriptionPeriod` and `subscriptionPrice` fields to `ChatInviteLink` type.
- New #117: Add `untilDate` field to `ChatMemberMember` type.

## 0.4.1 August 1, 2024

- New #115: Add `hasMainWebApp` field to `User` type.
- New #115: Add `businessConnectionId` parameter to `PinChatMessage` and `UnpinChatMessage` methods.

## 0.4.0 July 10, 2024

- New #103: Add `Update::getRaw()` method that returns raw data if type created by `Update::fromJson()` or
  `Update::fromServerRequest()`.
- New #106, #112: Add logging.
- Chg #105: Remove `InvalidResponseFormatException` in favor `TelegramParseResultException`.
- Chg #109: Rename `FailResult` property `$error_code` to `$errorCode`.

## 0.3.0 July 7, 2024

- New #100: Add `refundedPayment` parameter to `Message` type and add `RefundedPayment` type.
- Chg #99: Add `ResultFactory` and value processors, simplify type and method classes.

## 0.2.1 July 2, 2024

- New #91: Add `TransactionPartnerTelegramAds` type.
- New #92: Add `canSendPaidMedia` parameter to `ChatFullInfo` type.
- New #93: Add `paidMedia` parameter to `Message` and `ExternalReplyInfo` types, add `PaidMediaInfo`,
  `PaidMediaPreview`, `PaidMediaPhoto`, `PaidMediaVideo` types.
- New #94: Add `invoicePayload` parameter to `TransactionPartnerUser` type.
- New #95: Add `sendPaidMedia` method and `InputPaidMediaPhoto`, `InputPaidMediaVideo` types.

## 0.2.0 June 29, 2024

- New #16: Add `sendContact` method.
- New #17: Add `getUserProfilePhotos` method and `UserProfilePhotos` type.
- New #18: Add `sendPoll` method and `InputPollOption` type.
- New #19: Add `sendAudio` method.
- New #20: Add `sendDocument` method.
- New #21: Add `sendVideo` method.
- New #22: Add `getStarTransactions` method and `StarTransactions`, `StarTransaction`, `TransactionPartner`,
  `RevenueWithdrawalState` types.
- New #23: Add `logOut` and `close` methods.
- New #25: Add `forwardMessage` and `forwardMessages` methods, and `MessageId` type.
- New #26: Add `copyMessage` and `copyMessages` methods.
- New #27: Add `sendAnimation` method.
- New #28: Add `sendVoice` method.
- New #29: Add `sendVideoNote` method.
- New #31: Add `sendMediaGroup` method and `InputMediaAnimation`, `InputMediaAudio`, `InputMediaDocument`,
  `InputMediaPhoto`, `InputMediaVideo` types.
- New #32: Add `setMessageReaction` method and `ReactionType::toRequestArray()` method.
- New #33: Add `banChatMember` and `unbanChatMember` methods.
- New #34: Add `restrictChatMember` method and `ChatPermissions::toRequestArray()` method.
- New #35: Add `promoteChatMember` method.
- New #36: Add `setChatAdministratorCustomTitle` method.
- New #37: Add `banChatSenderChat` and `unbanChatSenderChat` methods.
- New #38: Add `setChatPermissions` method.
- New #39: Add `exportChatInviteLink`, `createChatInviteLink`, `editChatInviteLink` and `revokeChatInviteLink` methods.
- New #40: Add `approveChatJoinRequest` and `declineChatJoinRequest` methods.
- New #42: Add `setChatPhoto` and `deleteChatPhoto` methods.
- New #43: Add `setChatTitle` and `setChatDescription` methods.
- New #44: Add `pinChatMessage`, `unpinChatMessage` and `unpinAllChatMessages` methods.
- New #46: Add `leaveChat` method.
- New #47: Add `getChatAdministrators`, `getChatMemberCount` and `getChatMember` methods.
- New #49: Add `createNewStickerSet` method, `InputSticker` type, `StickerType` and `StickerFormat` classes with
  constants, and `MaskPosition::toRequestArray()` method.
- New #50: Add `deleteStickerSet` method.
- New #51: Add `getStickerSet` method and `StickerSet` type.
- New #52: Add `sendSticker` method.
- New #54: Add `getCustomEmojiStickers` method.
- New #55: Add `uploadStickerFile` method.
- New #57: Add `addStickerToSet`, `deleteStickerFromSet` and `replaceStickerInSet` methods.
- New #58: Add `setStickerPositionInSet`, `setStickerEmojiList`, `setStickerKeywords` and `setStickerMaskPosition`
  methods.
- New #60: Add `setStickerSetTitle` method.
- New #61: Add `setStickerSetThumbnail` method.
- New #62: Add `setCustomEmojiStickerSetThumbnail` method.
- New #63: Add `setChatStickerSet` and `deleteChatStickerSet` methods.
- New #64: Add `getForumTopicIconStickers` method.
- New #65: Add `createForumTopic`, `editForumTopic`, `closeForumTopic`, `reopenForumTopic`, `deleteForumTopic` methods,
  `ForumTopic` type and `ForumTopicIconColor` class with constants.
- New #66: Add `unpinAllForumTopicMessages` and `unpinAllGeneralForumTopicMessages` methods.
- New #67: Add `editGeneralForumTopic`, `closeGeneralForumTopic`, `reopenGeneralForumTopic`, `hideGeneralForumTopic`
  and `unhideGeneralForumTopic` methods.
- New #68: Add `answerCallbackQuery` method.
- New #69: Add `getUserChatBoosts` method and `UserChatBoosts` type.
- New #70: Add `getBusinessConnection` method.
- New #71: Add `getMyDefaultAdministratorRights` and `setMyDefaultAdministratorRights` methods.
- New #72: Add `editMessageText` method and `ParseMode` class with constants.
- New #73: Add `editMessageCaption` method.
- New #74: Add `editMessageMedia` method and `MessageEntityType` class with constants.
- New #75: Add `editMessageLiveLocation` and `stopMessageLiveLocation` methods.
- New #76: Add `editMessageReplyMarkup` method.
- New #77: Add `stopPoll` method.
- New #78: Add `deleteMessage` and `deleteMessages` methods.
- New #79: Add `answerInlineQuery` method, `InlineQueryResultsButton`, `InlineQueryResult*`, `InputMessageContent*` and
  `LabeledPrice` types.
- New #80: Add `answerWebAppQuery` method and `SentWebAppMessage` type.
- New #81: Add `sendInvoice` method.
- New #82: Add `createInvoiceLink` method.
- New #83: Add `answerShippingQuery` and `answerPreCheckoutQuery` methods, and `ShippingOption` type.
- New #84: Add `refundStarPayment` method.
- New #85: Add `setPassportDataErrors` method and `PassportElementError*` types.
- New #86: Add `sendGame` method.
- New #87: Add `setGameScore` method.
- New #88: Add `getGameHighScores` method and `GameHighScore` type.
- Chg #24: Move update methods to `Vjik\TelegramBot\Api\Method\Update` namespace, and update types to
  `Vjik\TelegramBot\Api\Type\Update` namespace.
- Chg #30: Remove `TelegramRequestWithFilesInterface`.
- Chg #59: Change namespaces `Vjik\TelegramBot\Api\Type\Payments` to `Vjik\TelegramBot\Api\Type\Payment`
  and `Vjik\TelegramBot\Api\Method\Payments` to `Vjik\TelegramBot\Api\Method\Payment`.
- Enh #56: Add specific exception on unsuccessfully opening a file in `InputFile::fromLocalFile()`.
- Bug #48: Fix incorrect string values addition to POST request with files in `PsrTelegramClient`.
- Bug #53: Fix incorrect array values addition to GET request in `PsrTelegramClient`.

## 0.1.0 June 10, 2024

- Initial release.
