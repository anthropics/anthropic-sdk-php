<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why a workflow run did not finish, or was not created. More types may be added. On `workflow_run.status_ended`, for a `type` you do not recognize, rely on the event's `result.type`.
 *
 * @phpstan-import-type ManagedAgentsTimeoutWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTimeoutWorkflowRunError
 * @phpstan-import-type ManagedAgentsProgramWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsProgramWorkflowRunError
 * @phpstan-import-type ManagedAgentsUnknownWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownWorkflowRunError
 * @phpstan-import-type ManagedAgentsThreadLimitWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsThreadLimitWorkflowRunError
 * @phpstan-import-type ManagedAgentsMaxWorkflowRunsWorkflowRunErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMaxWorkflowRunsWorkflowRunError
 *
 * @phpstan-type ManagedAgentsWorkflowRunErrorVariants = ManagedAgentsTimeoutWorkflowRunError|ManagedAgentsProgramWorkflowRunError|ManagedAgentsUnknownWorkflowRunError|ManagedAgentsThreadLimitWorkflowRunError|ManagedAgentsMaxWorkflowRunsWorkflowRunError
 * @phpstan-type ManagedAgentsWorkflowRunErrorShape = ManagedAgentsWorkflowRunErrorVariants|ManagedAgentsTimeoutWorkflowRunErrorShape|ManagedAgentsProgramWorkflowRunErrorShape|ManagedAgentsUnknownWorkflowRunErrorShape|ManagedAgentsThreadLimitWorkflowRunErrorShape|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorShape
 */
final class ManagedAgentsWorkflowRunError implements ConverterSource
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
            'timeout_error' => ManagedAgentsTimeoutWorkflowRunError::class,
            'program_error' => ManagedAgentsProgramWorkflowRunError::class,
            'unknown_error' => ManagedAgentsUnknownWorkflowRunError::class,
            'thread_limit_error' => ManagedAgentsThreadLimitWorkflowRunError::class,
            'max_workflow_runs_error' => ManagedAgentsMaxWorkflowRunsWorkflowRunError::class,
        ];
    }
}
