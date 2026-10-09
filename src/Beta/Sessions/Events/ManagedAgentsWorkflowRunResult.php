<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How a workflow run ended.
 *
 * @phpstan-import-type ManagedAgentsWorkflowRunResultCompletedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultCompleted
 * @phpstan-import-type ManagedAgentsWorkflowRunResultErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultError
 * @phpstan-import-type ManagedAgentsWorkflowRunResultStoppedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultStopped
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultVariants = ManagedAgentsWorkflowRunResultCompleted|ManagedAgentsWorkflowRunResultError|ManagedAgentsWorkflowRunResultStopped
 * @phpstan-type ManagedAgentsWorkflowRunResultShape = ManagedAgentsWorkflowRunResultVariants|ManagedAgentsWorkflowRunResultCompletedShape|ManagedAgentsWorkflowRunResultErrorShape|ManagedAgentsWorkflowRunResultStoppedShape
 */
final class ManagedAgentsWorkflowRunResult implements ConverterSource
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
            'completed' => ManagedAgentsWorkflowRunResultCompleted::class,
            'error' => ManagedAgentsWorkflowRunResultError::class,
            'stopped' => ManagedAgentsWorkflowRunResultStopped::class,
        ];
    }
}
