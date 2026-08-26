<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig;

use Anthropic\Beta\Organization\Workspaces\AllowedInferenceGeo;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * Permitted inference geo values. Defaults to 'unrestricted' if omitted, which allows all geos. Use the string 'unrestricted' to allow all geos, or a list of specific geos.
 *
 * @phpstan-type AllowedInferenceGeosVariants = 'unrestricted'|list<value-of<AllowedInferenceGeo>>
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
        return [new ListOf(AllowedInferenceGeo::class), 'string'];
    }
}
