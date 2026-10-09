<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * Opt-in server-side retry on one or more substitute models when the requested model declines for policy reasons. Tried in order: if the first entry also declines, the second is tried, and so on. Some models don't support fallbacks; on those models, a list of fallback models returns a 400 error. See [Server-side fallback](https://platform.claude.com/docs/en/build-with-claude/refusals-and-fallback#server-side-fallback). The string "default" requests the requested model's server-defined default fallback configuration. On a model that doesn't support fallbacks, the request runs on the requested model alone, so a declined request stays declined.
 *
 * @phpstan-import-type BetaFallbackParamShape from \Anthropic\Beta\Messages\BetaFallbackParam
 *
 * @phpstan-type BetaFallbacksParamVariants = 'default'|list<BetaFallbackParam>
 * @phpstan-type BetaFallbacksParamShape = BetaFallbacksParamVariants|list<BetaFallbackParamShape>
 */
final class BetaFallbacksParam implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [new ListOf(BetaFallbackParam::class), new ConstantOf('default')];
    }
}
