<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\DreamCreateParams;

use Anthropic\Beta\Dreams\BetaDreamModelConfigParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The model that runs a dream, given as a model ID or as an object with `id` and `speed`.
 *
 * In the object form, `speed` can only be `standard`.
 *
 * The [limits table in the Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#limits) lists the supported models.
 *
 * @phpstan-import-type BetaDreamModelConfigParamShape from \Anthropic\Beta\Dreams\BetaDreamModelConfigParam
 *
 * @phpstan-type ModelVariants = string|BetaDreamModelConfigParam
 * @phpstan-type ModelShape = ModelVariants|BetaDreamModelConfigParamShape
 */
final class Model implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [BetaDreamModelConfigParam::class, 'string'];
    }
}
