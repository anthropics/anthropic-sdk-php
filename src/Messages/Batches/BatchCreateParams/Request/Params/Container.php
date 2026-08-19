<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request\Params;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams;

/**
 * Container identifier for reuse across requests.
 *
 * @phpstan-import-type ContainerParamsShape from \Anthropic\Messages\Batches\BatchCreateParams\Request\Params\Container\ContainerParams
 *
 * @phpstan-type ContainerVariants = string|ContainerParams
 * @phpstan-type ContainerShape = ContainerVariants|ContainerParamsShape
 */
final class Container implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [ContainerParams::class, 'string'];
    }
}
