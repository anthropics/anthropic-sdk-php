<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Where to act: either a viewport coordinate or an element reference.
 *
 * @phpstan-import-type BetaBrowserCoordinateTargetShape from \Anthropic\Beta\Messages\BetaBrowserCoordinateTarget
 * @phpstan-import-type BetaBrowserRefTargetShape from \Anthropic\Beta\Messages\BetaBrowserRefTarget
 *
 * @phpstan-type BetaBrowserClickTargetVariants = BetaBrowserCoordinateTarget|BetaBrowserRefTarget
 * @phpstan-type BetaBrowserClickTargetShape = BetaBrowserClickTargetVariants|BetaBrowserCoordinateTargetShape|BetaBrowserRefTargetShape
 */
final class BetaBrowserClickTarget implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'coordinate' => BetaBrowserCoordinateTarget::class,
            'ref' => BetaBrowserRefTarget::class,
        ];
    }
}
