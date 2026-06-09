<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSystemMessageEventParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An event sent to a session immediately after it is created. Supports `user.message`, `user.define_outcome`, and `system.message`.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams
 * @phpstan-import-type ManagedAgentsSystemMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSystemMessageEventParams
 *
 * @phpstan-type BetaManagedAgentsDeploymentInitialEventParamsVariants = ManagedAgentsUserMessageEventParams|ManagedAgentsUserDefineOutcomeEventParams|ManagedAgentsSystemMessageEventParams
 * @phpstan-type BetaManagedAgentsDeploymentInitialEventParamsShape = BetaManagedAgentsDeploymentInitialEventParamsVariants|ManagedAgentsUserMessageEventParamsShape|ManagedAgentsUserDefineOutcomeEventParamsShape|ManagedAgentsSystemMessageEventParamsShape
 */
final class BetaManagedAgentsDeploymentInitialEventParams implements ConverterSource
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
            'user.message' => ManagedAgentsUserMessageEventParams::class,
            'user.define_outcome' => ManagedAgentsUserDefineOutcomeEventParams::class,
            'system.message' => ManagedAgentsSystemMessageEventParams::class,
        ];
    }
}
