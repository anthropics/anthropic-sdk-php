<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams\BetaDream;

use Anthropic\Beta\Dreams\BetaDream\OutputBehavior\BetaOutputBehaviorCreateNew;
use Anthropic\Beta\Dreams\BetaDream\OutputBehavior\BetaOutputBehaviorUpdateExisting;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The default destination: the job creates a new output memory store as a clone of the memory_store input and writes the consolidated memories into it. The input store is never mutated.
 *
 * @phpstan-import-type BetaOutputBehaviorCreateNewShape from \Anthropic\Beta\Dreams\BetaDream\OutputBehavior\BetaOutputBehaviorCreateNew
 * @phpstan-import-type BetaOutputBehaviorUpdateExistingShape from \Anthropic\Beta\Dreams\BetaDream\OutputBehavior\BetaOutputBehaviorUpdateExisting
 *
 * @phpstan-type OutputBehaviorVariants = BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting
 * @phpstan-type OutputBehaviorShape = OutputBehaviorVariants|BetaOutputBehaviorCreateNewShape|BetaOutputBehaviorUpdateExistingShape
 */
final class OutputBehavior implements ConverterSource
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
}
