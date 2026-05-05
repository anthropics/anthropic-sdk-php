<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;

use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Rubric for grading the quality of an outcome.
 *
 * @phpstan-import-type ManagedAgentsFileRubricParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams
 * @phpstan-import-type ManagedAgentsTextRubricParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams
 *
 * @phpstan-type RubricVariants = ManagedAgentsFileRubricParams|ManagedAgentsTextRubricParams
 * @phpstan-type RubricShape = RubricVariants|ManagedAgentsFileRubricParamsShape|ManagedAgentsTextRubricParamsShape
 */
final class Rubric implements ConverterSource
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
            'file' => ManagedAgentsFileRubricParams::class,
            'text' => ManagedAgentsTextRubricParams::class,
        ];
    }
}
