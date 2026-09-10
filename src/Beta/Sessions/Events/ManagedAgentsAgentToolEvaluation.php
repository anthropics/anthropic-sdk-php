<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Names the resolved permission_policy that produced evaluated_permission, and under auto carries the judgement. Open union: clients must tolerate unknown variants.
 *
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAlwaysAllowShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAlwaysAllow
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAlwaysAskShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAlwaysAsk
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationAutoShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluationAuto
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
}
