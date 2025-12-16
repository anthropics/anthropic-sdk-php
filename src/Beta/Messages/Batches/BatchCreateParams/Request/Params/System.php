<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;

use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * System prompt.
 *
 * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
 *
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 *
 * @phpstan-type SystemShape = string|list<BetaTextBlockParamShape>
 */
final class System implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaTextBlockParam::class)];
    }
}
