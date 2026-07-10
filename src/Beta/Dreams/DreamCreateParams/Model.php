<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\DreamCreateParams;

use Anthropic\Beta\Dreams\BetaDreamModelConfigParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Model identifier and configuration applied to every pipeline stage.
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
        return ['string', BetaDreamModelConfigParam::class];
    }
}
