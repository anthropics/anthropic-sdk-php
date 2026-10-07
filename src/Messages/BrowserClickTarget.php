<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Where to act: either a viewport coordinate or an element reference.
 *
 * @phpstan-import-type BrowserCoordinateTargetShape from \Anthropic\Messages\BrowserCoordinateTarget
 * @phpstan-import-type BrowserRefTargetShape from \Anthropic\Messages\BrowserRefTarget
 *
 * @phpstan-type BrowserClickTargetVariants = BrowserCoordinateTarget|BrowserRefTarget
 * @phpstan-type BrowserClickTargetShape = BrowserClickTargetVariants|BrowserCoordinateTargetShape|BrowserRefTargetShape
 */
final class BrowserClickTarget implements ConverterSource
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
            'coordinate' => BrowserCoordinateTarget::class,
            'ref' => BrowserRefTarget::class,
        ];
    }
}
