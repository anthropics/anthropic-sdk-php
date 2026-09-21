<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluation\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Names the resolved permission_policy that produced evaluated_permission, and under auto carries the judgement. Open union: clients must tolerate unknown variants.
 *
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAlwaysAllowShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAlwaysAllow
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAlwaysAskShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAlwaysAsk
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAutoShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAuto
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermission
 *
 * @phpstan-type ManagedAgentsAgentToolEvaluationVariants = ManagedAgentsAgentToolEvaluationAlwaysAllow|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto
 * @phpstan-type ManagedAgentsAgentToolEvaluationShape = ManagedAgentsAgentToolEvaluationVariants|ManagedAgentsAgentToolEvaluationAlwaysAllowShape|ManagedAgentsAgentToolEvaluationAlwaysAskShape|ManagedAgentsAgentToolEvaluationAutoShape
 */
final class ManagedAgentsAgentToolEvaluation implements ConverterSource
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
            'always_allow' => ManagedAgentsAgentToolEvaluationAlwaysAllow::class,
            'always_ask' => ManagedAgentsAgentToolEvaluationAlwaysAsk::class,
            'auto' => ManagedAgentsAgentToolEvaluationAuto::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ManagedAgentsAgentAutoEvaluatedPermissionShape|null $evaluatedPermission
     *
     * @return ($type is Type::ALWAYS_ALLOW|'always_allow' ? ManagedAgentsAgentToolEvaluationAlwaysAllow : ($type is Type::ALWAYS_ASK|'always_ask' ? ManagedAgentsAgentToolEvaluationAlwaysAsk : ($type is Type::AUTO|'auto' ? ManagedAgentsAgentToolEvaluationAuto : ManagedAgentsAgentToolEvaluationAlwaysAllow|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ManagedAgentsAgentAutoEvaluatedPermissionAllow|array|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny|null $evaluatedPermission = null,
    ): ManagedAgentsAgentToolEvaluationAlwaysAllow|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto {
        return match ($type) {
            Type::ALWAYS_ALLOW, 'always_allow' => ManagedAgentsAgentToolEvaluationAlwaysAllow::with(
            ),
            Type::ALWAYS_ASK, 'always_ask' => ManagedAgentsAgentToolEvaluationAlwaysAsk::with(
            ),
            Type::AUTO, 'auto' => ManagedAgentsAgentToolEvaluationAuto::with(
                evaluatedPermission: $evaluatedPermission ?? throw new \ArgumentCountError('$evaluatedPermission is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
