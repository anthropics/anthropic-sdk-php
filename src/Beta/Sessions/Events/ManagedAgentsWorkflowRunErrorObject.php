<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why a workflow run did not finish, or was not created. More types may be added. On `workflow_run.status_ended`, for a `type` you do not recognize, rely on the event's `result.type`.
 *
 * @phpstan-import-type ManagedAgentsTimeoutWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTimeoutWorkflowRunErrorObject
 * @phpstan-import-type ManagedAgentsProgramWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsProgramWorkflowRunErrorObject
 * @phpstan-import-type ManagedAgentsUnknownWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownWorkflowRunErrorObject
 * @phpstan-import-type ManagedAgentsThreadLimitWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsThreadLimitWorkflowRunErrorObject
 * @phpstan-import-type ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject
 *
 * @phpstan-type ManagedAgentsWorkflowRunErrorObjectVariants = ManagedAgentsTimeoutWorkflowRunErrorObject|ManagedAgentsProgramWorkflowRunErrorObject|ManagedAgentsUnknownWorkflowRunErrorObject|ManagedAgentsThreadLimitWorkflowRunErrorObject|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject
 * @phpstan-type ManagedAgentsWorkflowRunErrorObjectShape = ManagedAgentsWorkflowRunErrorObjectVariants|ManagedAgentsTimeoutWorkflowRunErrorObjectShape|ManagedAgentsProgramWorkflowRunErrorObjectShape|ManagedAgentsUnknownWorkflowRunErrorObjectShape|ManagedAgentsThreadLimitWorkflowRunErrorObjectShape|ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObjectShape
 */
class ManagedAgentsWorkflowRunErrorObject implements ConverterSource
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
            'timeout_error' => ManagedAgentsTimeoutWorkflowRunErrorObject::class,
            'program_error' => ManagedAgentsProgramWorkflowRunErrorObject::class,
            'unknown_error' => ManagedAgentsUnknownWorkflowRunErrorObject::class,
            'thread_limit_error' => ManagedAgentsThreadLimitWorkflowRunErrorObject::class,
            'max_workflow_runs_error' => ManagedAgentsMaxWorkflowRunsWorkflowRunErrorObject::class,
        ];
    }
}

class_alias(
    ManagedAgentsWorkflowRunErrorObject::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunError',
);
