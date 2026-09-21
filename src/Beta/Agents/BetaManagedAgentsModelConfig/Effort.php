<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsModelConfig;

use Anthropic\Beta\Agents\BetaManagedAgentsEffortHigh;
use Anthropic\Beta\Agents\BetaManagedAgentsEffortLow;
use Anthropic\Beta\Agents\BetaManagedAgentsEffortMax;
use Anthropic\Beta\Agents\BetaManagedAgentsEffortMedium;
use Anthropic\Beta\Agents\BetaManagedAgentsEffortXhigh;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Effort\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How hard Claude works on each turn. Sets `output_config.effort` on every Messages call the session makes.
 *
 * @phpstan-import-type BetaManagedAgentsEffortLowShape from \Anthropic\Beta\Agents\BetaManagedAgentsEffortLow
 * @phpstan-import-type BetaManagedAgentsEffortMediumShape from \Anthropic\Beta\Agents\BetaManagedAgentsEffortMedium
 * @phpstan-import-type BetaManagedAgentsEffortHighShape from \Anthropic\Beta\Agents\BetaManagedAgentsEffortHigh
 * @phpstan-import-type BetaManagedAgentsEffortXhighShape from \Anthropic\Beta\Agents\BetaManagedAgentsEffortXhigh
 * @phpstan-import-type BetaManagedAgentsEffortMaxShape from \Anthropic\Beta\Agents\BetaManagedAgentsEffortMax
 *
 * @phpstan-type EffortVariants = BetaManagedAgentsEffortLow|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax
 * @phpstan-type EffortShape = EffortVariants|BetaManagedAgentsEffortLowShape|BetaManagedAgentsEffortMediumShape|BetaManagedAgentsEffortHighShape|BetaManagedAgentsEffortXhighShape|BetaManagedAgentsEffortMaxShape
 */
final class Effort implements ConverterSource
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
            'low' => BetaManagedAgentsEffortLow::class,
            'medium' => BetaManagedAgentsEffortMedium::class,
            'high' => BetaManagedAgentsEffortHigh::class,
            'xhigh' => BetaManagedAgentsEffortXhigh::class,
            'max' => BetaManagedAgentsEffortMax::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::LOW|'low' ? BetaManagedAgentsEffortLow : ($type is Type::MEDIUM|'medium' ? BetaManagedAgentsEffortMedium : ($type is Type::HIGH|'high' ? BetaManagedAgentsEffortHigh : ($type is Type::XHIGH|'xhigh' ? BetaManagedAgentsEffortXhigh : ($type is Type::MAX|'max' ? BetaManagedAgentsEffortMax : BetaManagedAgentsEffortLow|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaManagedAgentsEffortLow|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax {
        return match ($type) {
            Type::LOW, 'low' => BetaManagedAgentsEffortLow::with(type: 'low'),
            Type::MEDIUM, 'medium' => BetaManagedAgentsEffortMedium::with(
                type: 'medium'
            ),
            Type::HIGH, 'high' => BetaManagedAgentsEffortHigh::with(type: 'high'),
            Type::XHIGH, 'xhigh' => BetaManagedAgentsEffortXhigh::with(
                type: 'xhigh'
            ),
            Type::MAX, 'max' => BetaManagedAgentsEffortMax::with(type: 'max'),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
