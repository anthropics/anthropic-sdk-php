<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermission\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The server's per-invocation judgement under the auto permission policy. Its type always equals the event's top-level evaluated_permission. Open union: clients must tolerate unknown variants.
 *
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionAllowShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermissionAllow
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionAskShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermissionAsk
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionDenyShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermissionDeny
 *
 * @phpstan-type ManagedAgentsAgentAutoEvaluatedPermissionVariants = ManagedAgentsAgentAutoEvaluatedPermissionAllow|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny
 * @phpstan-type ManagedAgentsAgentAutoEvaluatedPermissionShape = ManagedAgentsAgentAutoEvaluatedPermissionVariants|ManagedAgentsAgentAutoEvaluatedPermissionAllowShape|ManagedAgentsAgentAutoEvaluatedPermissionAskShape|ManagedAgentsAgentAutoEvaluatedPermissionDenyShape
 */
final class ManagedAgentsAgentAutoEvaluatedPermission implements ConverterSource
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
            'allow' => ManagedAgentsAgentAutoEvaluatedPermissionAllow::class,
            'ask' => ManagedAgentsAgentAutoEvaluatedPermissionAsk::class,
            'deny' => ManagedAgentsAgentAutoEvaluatedPermissionDeny::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALLOW|'allow' ? ManagedAgentsAgentAutoEvaluatedPermissionAllow : ($type is Type::ASK|'ask' ? ManagedAgentsAgentAutoEvaluatedPermissionAsk : ($type is Type::DENY|'deny' ? ManagedAgentsAgentAutoEvaluatedPermissionDeny : ManagedAgentsAgentAutoEvaluatedPermissionAllow|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $reasonCode = null
    ): ManagedAgentsAgentAutoEvaluatedPermissionAllow|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny {
        return match ($type) {
            Type::ALLOW, 'allow' => ManagedAgentsAgentAutoEvaluatedPermissionAllow::with(
            ),
            Type::ASK, 'ask' => ManagedAgentsAgentAutoEvaluatedPermissionAsk::with(
                reasonCode: $reasonCode ?? throw new \ArgumentCountError('$reasonCode is required'),
            ),
            Type::DENY, 'deny' => ManagedAgentsAgentAutoEvaluatedPermissionDeny::with(
                reasonCode: $reasonCode ?? throw new \ArgumentCountError('$reasonCode is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
