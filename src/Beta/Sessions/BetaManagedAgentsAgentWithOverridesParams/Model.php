<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsAgentWithOverridesParams;

use Anthropic\Beta\Agents\BetaManagedAgentsModel;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Replacement model. Accepts the model string, e.g. `claude-opus-4-6`, or a `model_config` object. Omit to use the agent's model.
 *
 * @phpstan-import-type BetaManagedAgentsModelConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams
 *
 * @phpstan-type ModelVariants = BetaManagedAgentsModelConfigParams|value-of<BetaManagedAgentsModel>
 * @phpstan-type ModelShape = ModelVariants|BetaManagedAgentsModelConfigParamsShape
 */
final class Model implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaManagedAgentsModel::class, BetaManagedAgentsModelConfigParams::class,
        ];
    }
}
