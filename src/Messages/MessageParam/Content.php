<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\ContentBlockParam;
use Anthropic\Messages\DocumentBlockParam;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\RedactedThinkingBlockParam;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\ServerToolUseBlockParam;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ThinkingBlockParam;
use Anthropic\Messages\ToolResultBlockParam;
use Anthropic\Messages\ToolUseBlockParam;
use Anthropic\Messages\WebSearchToolResultBlockParam;

/**
 * @phpstan-type content_alias = string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>
 */
final class Content implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(ContentBlockParam::class)];
    }
}
