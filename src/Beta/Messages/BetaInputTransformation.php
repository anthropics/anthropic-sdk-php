<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaInputTransformation\Type;
use Anthropic\Beta\Messages\BetaThinkingDroppedInputTransformation\Reason;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One entry of `input_transformations`: either a change the API made to the
 * request's input before showing it to the model, or a block that failed a
 * binding check and was still shown to the model unchanged. The `type` field
 * says which.
 *
 * @phpstan-import-type BetaThinkingDroppedInputTransformationShape from \Anthropic\Beta\Messages\BetaThinkingDroppedInputTransformation
 * @phpstan-import-type BetaThinkingMismatchAllowedInputTransformationShape from \Anthropic\Beta\Messages\BetaThinkingMismatchAllowedInputTransformation
 *
 * @phpstan-type BetaInputTransformationVariants = BetaThinkingDroppedInputTransformation|BetaThinkingMismatchAllowedInputTransformation
 * @phpstan-type BetaInputTransformationShape = BetaInputTransformationVariants|BetaThinkingDroppedInputTransformationShape|BetaThinkingMismatchAllowedInputTransformationShape
 */
final class BetaInputTransformation implements ConverterSource
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
            'thinking_dropped' => BetaThinkingDroppedInputTransformation::class,
            'thinking_mismatch_allowed' => BetaThinkingMismatchAllowedInputTransformation::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::THINKING_DROPPED|'thinking_dropped' ? Reason|value-of<Reason> : BetaThinkingMismatchAllowedInputTransformation\Reason|value-of<BetaThinkingMismatchAllowedInputTransformation\Reason>) $reason
     *
     * @return ($type is Type::THINKING_DROPPED|'thinking_dropped' ? BetaThinkingDroppedInputTransformation : ($type is Type::THINKING_MISMATCH_ALLOWED|'thinking_mismatch_allowed' ? BetaThinkingMismatchAllowedInputTransformation : BetaThinkingDroppedInputTransformation|BetaThinkingMismatchAllowedInputTransformation))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $path,
        Reason|BetaThinkingMismatchAllowedInputTransformation\Reason|string $reason,
    ): BetaThinkingDroppedInputTransformation|BetaThinkingMismatchAllowedInputTransformation {
        return match ($type) {
            Type::THINKING_DROPPED, 'thinking_dropped' => BetaThinkingDroppedInputTransformation::with(
                path: $path,
                reason: $reason
            ),
            Type::THINKING_MISMATCH_ALLOWED, 'thinking_mismatch_allowed' => BetaThinkingMismatchAllowedInputTransformation::with(
                path: $path,
                // @phpstan-ignore argument.type
                reason: $reason,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
