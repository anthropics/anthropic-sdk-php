<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;

use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Container identifier for reuse across requests.
 *
 * @phpstan-import-type BetaContainerParamsShape from \Anthropic\Beta\Messages\BetaContainerParams
 *
 * @phpstan-type ContainerShape = string|BetaContainerParamsShape
 */
final class Container implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [BetaContainerParams::class, 'string'];
    }
}
