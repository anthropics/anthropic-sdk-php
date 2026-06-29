<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request\Params;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\TextBlockParam;

/**
 * System prompt.
 *
 * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://platform.claude.com/docs/en/build-with-claude/prompt-engineering/claude-prompting-best-practices#give-claude-a-role).
 *
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 *
 * @phpstan-type SystemVariants = string|list<TextBlockParam>
 * @phpstan-type SystemShape = SystemVariants|list<TextBlockParamShape>
 */
final class System implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(TextBlockParam::class)];
    }
}
