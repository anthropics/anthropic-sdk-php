<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\DataResidency;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * Permitted inference geo values. 'unrestricted' means all geos are allowed.
 *
 * @phpstan-type AllowedInferenceGeosVariants = 'unrestricted'|list<string>
 * @phpstan-type AllowedInferenceGeosShape = AllowedInferenceGeosVariants
 */
final class AllowedInferenceGeos implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [new ListOf('string'), 'string'];
    }
}
