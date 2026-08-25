# Agent Guidelines

## Project Layout

| Bot API concept | File |
| --- | --- |
| Type | `src/Type/<Name>.php` (`Phptg\BotApi\Type`) |
| Method | `src/Method/<Name>.php` (`Phptg\BotApi\Method`) |
| Facade shortcut | a method on `src/TelegramBotApi.php` |
| Union/interface dispatch | `src/ParseResult/ValueProcessor/<Name>Value.php` — see *Interfaces and Unions* |

The subdirectories under `src/Type` and `src/Method` are legacy. Never put a new class there — every new type
and method goes directly into `src/Type` and `src/Method`.

Tests mirror the source path: `src/Type/Foo.php` → `tests/Type/FooTest.php`.

## Result Types

Objects the API returns:

```php
<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#community
 *
 * @api
 */
final readonly class Community
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
```

- `final readonly`, promoted **public** properties, `@see` link to the anchor on
  `https://core.telegram.org/bots/api`, `@api` in the doc block.
- Property names are camelCase; `ObjectFactory` maps them from the snake_case JSON keys
  automatically. No mapping code is needed for the common case.
- Required fields first, then optional ones as `?T $x = null`, in Bot API order.
- `Optional. True, if …` becomes `?true $x = null`, not `?bool`.
- Unix timestamps become `DateTimeImmutable` (`DateValue` handles the conversion).
- Arrays need an attribute and a `@param` line:
  ```php
  /**
   * @param Chat[] $chats
   * @param string[]|null $countryCodes
   */
  public function __construct(
      #[ArrayOfObjectsValue(Chat::class)]
      public array $chats,
      #[ArrayMap(StringValue::class)]
      public ?array $countryCodes = null,
  ) {}
  ```
  Array of arrays of objects: `#[ArrayOfArraysOfObjectsValue(...)]`.

## Input Types

Objects sent to the API additionally expose serialization:

```php
final readonly class InputRichBlockParagraph implements InputRichBlock
{
    public function __construct(
        public string|array|RichText $text,
    ) {}

    public function getType(): string
    {
        return 'paragraph';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
        ];
    }
}
```

- Drop `null` values from the produced array the same way the neighbouring class does.
- A type that can carry an uploaded file takes the `?FileCollector $fileCollector = null` argument
  and registers the file through it.

## Interfaces and Unions

A Bot API "can be one of" type becomes an interface in `src/Type`, usually declaring `getType()`,
with `@see` and `@api` in the doc block — for example `src/Type/RichBlock.php`.

A value processor is needed only for unions the API **returns**. Types that are only sent
(`InputRichBlock`, `InputMedia`, `InputPaidMedia`, `InputProfilePhoto`, …) have no processor at all:
they are serialized by `toRequestArray()`.

For a returned union add
`src/ParseResult/ValueProcessor/RichBlockValue.php` — `final readonly class ... extends
InterfaceValue`, with `@template-extends InterfaceValue<RichBlock>` and three methods:

- `getTypeKey()` — the discriminator field, usually `'type'`;
- `getClassMap()` — discriminator value → class;
- `getUnknownTypeMessage()` — the message of the exception thrown for an unknown discriminator,
  e.g. `'Unknown rich block type.'`.

All three are abstract in `InterfaceValue`; forgetting the last one leaves the class abstract.

Then wire the processor up. There are two ways, and they are not interchangeable:

- The interface is the declared type of a property — register the processor in
  `ObjectFactory::getTypeMap()`: `RichBlock::class => new RichBlockValue(),`. This covers every
  property of that type at once.
- The interface appears inside an array, or the property needs a processor the type alone cannot
  imply — put the processor on the property as an attribute:
  `#[ArrayMap(PaidMediaValue::class)]` in `PaidMediaInfo`, `#[MaybeInaccessibleMessageValue]` in
  `Message`. Such processors are *not* in `getTypeMap()`.

Every implementation must be added to `getClassMap()`, otherwise parsing silently fails.

## Methods

```php
final readonly class DeleteEphemeralMessage implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $receiverUserId,
        private int $ephemeralMessageId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteEphemeralMessage';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'receiver_user_id' => $this->receiverUserId,
            'ephemeral_message_id' => $this->ephemeralMessageId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
```

- `final readonly`, promoted **private** properties, `@see` link, and
  `@template-implements MethodInterface<Result>` in the doc block (`<true>` for methods returning
  `True`).
- `getData()` returns snake_case keys. When optional parameters exist, wrap the array in
  `array_filter(..., static fn(mixed $value): bool => $value !== null)`.
- Nested objects are serialized with `?->toRequestArray()`; arrays of objects with `array_map`.
- Result processors: `TrueValue`, `ObjectValue(Message::class)`, `ArrayOfObjectsValue(...)`,
  `StringValue`, `ObjectOrTrueValue`, … — pick the one used by the closest existing method.

## Facade

Every method class gets a shortcut on `src/TelegramBotApi.php`. The list is alphabetical — insert
the new method next to its alphabetical neighbours, and add the matching `use` import:

```php
/**
 * @see https://core.telegram.org/bots/api#deleteephemeralmessage
 */
public function deleteEphemeralMessage(
    int|string $chatId,
    int $receiverUserId,
    int $ephemeralMessageId,
): FailResult|true {
    return $this->call(new DeleteEphemeralMessage($chatId, $receiverUserId, $ephemeralMessageId));
}
```

The return type is `FailResult|<result type>`.

## Writing Tests

- For `InputFile|string` parameters, the string must be a file ID, not a URL.
- Assertions are the imported `PHPUnit\Framework\assert*` functions, not `$this->assert*`.
- Test case names are fixed. `testBase()` is always the minimal object — required arguments only —
  and `testFull()` is the same object with **every** optional argument passed. Do not invent other
  names; a handful of old tests use `testFilled()` or `testFromTelegramResultMinimal()`, they are
  not the convention.
- Result types — `tests/Type/<Name>Test.php`. Without optional fields, two cases:
  ```php
  final class CommunityTest extends TestCase
  {
      public function testBase(): void
      {
          $community = new Community(123, 'My Community');

          assertSame(123, $community->id);
          assertSame('My Community', $community->name);
      }

      public function testFromTelegramResult(): void
      {
          $community = (new ObjectFactory())->create([
              'id' => 123,
              'name' => 'My Community',
          ], null, Community::class);

          assertSame(123, $community->id);
          assertSame('My Community', $community->name);
      }
  }
  ```
  With optional fields, four:

  | Case | What it does |
  | --- | --- |
  | `testBase()` | required arguments only; asserts every optional field is `null` |
  | `testFull()` | all optional arguments passed; asserts each of them |
  | `testFromTelegramResult()` | `ObjectFactory` on the minimal payload; asserts the optional fields are `null` |
  | `testFromTelegramResultFull()` | `ObjectFactory` on the payload with every key present |

  In the `FromTelegramResult` cases nested objects are checked with `assertInstanceOf()` plus a
  couple of their fields — see `tests/Type/RichBlockAnimationTest.php`.
- Input types — same `testBase()`/`testFull()` split, but each case asserts the exact
  `toRequestArray()` array instead of the properties. A type that accepts an `InputFile` gets one
  more case, `testFileCollectorIsPropagated()`, which passes a `FileCollector`, expects
  `attach://file0` in the array and asserts `$fileCollector->get()`.
- Methods — `tests/Method/<Name>Test.php`: `testBase()` asserts `getHttpMethod()`, `getApiMethod()`
  and the exact `getData()` array; `testFull()` repeats it with every optional parameter passed
  (keys in `getData()` order, not in constructor order); `testPrepareResult()` runs the method
  through `TestHelper::createSuccessStubApi(...)`.
- Facade — one `test<MethodName>()` in `tests/TelegramBotApi/TelegramBotApiTest.php`, alphabetically
  placed, using `TestHelper::createSuccessStubApi(...)`: build the stub, call the method, assert the
  result. Optional parameters are not repeated here — they are already covered by the method test.
- New fields on existing types extend the existing test of that type rather than adding a new file:
  the new field goes into `testFull()` and `testFromTelegramResultFull()`, and into `testBase()` /
  `testFromTelegramResult()` as a `null` assertion.

## Preserving Backward Compatibility

- Backward compatibility should be preserved as much as possible.
- A new parameter is always added last (with a default value), regardless of its position in the Bot API docs.
- The same holds for a new field on an existing type: it goes after the existing constructor
  parameters, even though `getData()` still lists it in its Bot API position.

## CHANGELOG

Entries go under the existing `## X.Y.Z under development` heading (create one if the top section
is already released). Format: `- <Type> #<PR>: <text>`, wrapped at 120 characters, continuation
lines indented by two spaces.

- `New` — new types, methods, fields, parameters.
- `Chg` — behaviour or signature changes.
- `Enh` — improvements to existing code.
- `Bug` — fixes.

Group related additions into a single entry:

```markdown
- New #211: Add `InputMediaVoiceNote`, `InputRichMessageMedia`, `Community` and
  `CommunityChatAdded` types.
- New #211: Add `receiverUserId` and `callbackQueryId` parameters to `SendMessage`, `SendAnimation`
  and `SendAudio` methods.
- Chg #211: Make `messageId` field of `ReplyParameters` type optional.
```

Class, field and parameter names in the changelog are the **PHP** names (camelCase), not the Bot
API ones.
