<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaOutputBehavior\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
 *
 * @phpstan-import-type BetaOutputBehaviorCreateNewShape from \Anthropic\Beta\Dreams\BetaOutputBehaviorCreateNew
 * @phpstan-import-type BetaOutputBehaviorUpdateExistingShape from \Anthropic\Beta\Dreams\BetaOutputBehaviorUpdateExisting
 *
 * @phpstan-type BetaOutputBehaviorVariants = BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting
 * @phpstan-type BetaOutputBehaviorShape = BetaOutputBehaviorVariants|BetaOutputBehaviorCreateNewShape|BetaOutputBehaviorUpdateExistingShape
 */
final class BetaOutputBehavior implements ConverterSource
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
            'create_new' => BetaOutputBehaviorCreateNew::class,
            'update_existing' => BetaOutputBehaviorUpdateExisting::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CREATE_NEW|'create_new' ? BetaOutputBehaviorCreateNew : ($type is Type::UPDATE_EXISTING|'update_existing' ? BetaOutputBehaviorUpdateExisting : BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $memoryStoreID = null
    ): BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting {
        return match ($type) {
            Type::CREATE_NEW, 'create_new' => BetaOutputBehaviorCreateNew::with(
                type: 'create_new'
            ),
            Type::UPDATE_EXISTING, 'update_existing' => BetaOutputBehaviorUpdateExisting::with(
                type: 'update_existing',
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
