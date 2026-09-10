<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

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
}
