<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionCreateParams;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An event sent to the `session` immediately after it is created. Supports `user.message` and `user.define_outcome`.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams
 *
 * @phpstan-type InitialEventVariants = ManagedAgentsUserMessageEventParams|ManagedAgentsUserDefineOutcomeEventParams
 * @phpstan-type InitialEventShape = InitialEventVariants|ManagedAgentsUserMessageEventParamsShape|ManagedAgentsUserDefineOutcomeEventParamsShape
 */
final class InitialEvent implements ConverterSource
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
        ];
    }
}
