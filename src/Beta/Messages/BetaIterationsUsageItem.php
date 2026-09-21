<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaIterationsUsageItem\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Model;

/**
 * @phpstan-import-type BetaMessageIterationUsageShape from \Anthropic\Beta\Messages\BetaMessageIterationUsage
 * @phpstan-import-type BetaCompactionIterationUsageShape from \Anthropic\Beta\Messages\BetaCompactionIterationUsage
 * @phpstan-import-type BetaAdvisorMessageIterationUsageShape from \Anthropic\Beta\Messages\BetaAdvisorMessageIterationUsage
 * @phpstan-import-type BetaFallbackMessageIterationUsageShape from \Anthropic\Beta\Messages\BetaFallbackMessageIterationUsage
 * @phpstan-import-type BetaCacheCreationShape from \Anthropic\Beta\Messages\BetaCacheCreation
 *
 * @phpstan-type BetaIterationsUsageItemVariants = BetaMessageIterationUsage|BetaCompactionIterationUsage|BetaAdvisorMessageIterationUsage|BetaFallbackMessageIterationUsage
 * @phpstan-type BetaIterationsUsageItemShape = BetaIterationsUsageItemVariants|BetaMessageIterationUsageShape|BetaCompactionIterationUsageShape|BetaAdvisorMessageIterationUsageShape|BetaFallbackMessageIterationUsageShape
 */
final class BetaIterationsUsageItem implements ConverterSource
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
            'message' => BetaMessageIterationUsage::class,
            'compaction' => BetaCompactionIterationUsage::class,
            'advisor_message' => BetaAdvisorMessageIterationUsage::class,
            'fallback_message' => BetaFallbackMessageIterationUsage::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaCacheCreation|BetaCacheCreationShape|null $cacheCreation
     * @param string|Model|value-of<Model>|null $model
     *
     * @return ($type is Type::MESSAGE|'message' ? BetaMessageIterationUsage : ($type is Type::COMPACTION|'compaction' ? BetaCompactionIterationUsage : ($type is Type::ADVISOR_MESSAGE|'advisor_message' ? BetaAdvisorMessageIterationUsage : ($type is Type::FALLBACK_MESSAGE|'fallback_message' ? BetaFallbackMessageIterationUsage : BetaMessageIterationUsage|BetaCompactionIterationUsage|BetaAdvisorMessageIterationUsage|BetaFallbackMessageIterationUsage))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaCacheCreation|array|null $cacheCreation,
        int $inputTokens,
        int $outputTokens,
        int $cacheCreationInputTokens = 0,
        int $cacheReadInputTokens = 0,
        Model|string|null $model = null,
    ): BetaMessageIterationUsage|BetaCompactionIterationUsage|BetaAdvisorMessageIterationUsage|BetaFallbackMessageIterationUsage {
        return match ($type) {
            Type::MESSAGE, 'message' => BetaMessageIterationUsage::with(
                cacheCreation: $cacheCreation,
                cacheCreationInputTokens: $cacheCreationInputTokens,
                cacheReadInputTokens: $cacheReadInputTokens,
                inputTokens: $inputTokens,
                model: $model,
                outputTokens: $outputTokens,
            ),
            Type::COMPACTION, 'compaction' => BetaCompactionIterationUsage::with(
                cacheCreation: $cacheCreation,
                cacheCreationInputTokens: $cacheCreationInputTokens,
                cacheReadInputTokens: $cacheReadInputTokens,
                inputTokens: $inputTokens,
                outputTokens: $outputTokens,
            ),
            Type::ADVISOR_MESSAGE, 'advisor_message' => BetaAdvisorMessageIterationUsage::with(
                cacheCreation: $cacheCreation,
                cacheCreationInputTokens: $cacheCreationInputTokens,
                cacheReadInputTokens: $cacheReadInputTokens,
                inputTokens: $inputTokens,
                model: $model ?? throw new \ArgumentCountError('$model is required'),
                outputTokens: $outputTokens,
            ),
            Type::FALLBACK_MESSAGE, 'fallback_message' => BetaFallbackMessageIterationUsage::with(
                cacheCreation: $cacheCreation,
                cacheCreationInputTokens: $cacheCreationInputTokens,
                cacheReadInputTokens: $cacheReadInputTokens,
                inputTokens: $inputTokens,
                model: $model ?? throw new \ArgumentCountError('$model is required'),
                outputTokens: $outputTokens,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
