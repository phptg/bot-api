<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareatypeweather
 *
 * @api
 */
final readonly class StoryAreaTypeWeather implements StoryAreaType
{
    public function __construct(
        public float $temperature,
        public string $emoji,
        public int $backgroundColor,
    ) {}

    public function getType(): string
    {
        return 'weather';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'temperature' => $this->temperature,
            'emoji' => $this->emoji,
            'background_color' => $this->backgroundColor,
        ];
    }
}
