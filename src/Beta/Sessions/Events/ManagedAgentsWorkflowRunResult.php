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
 * @phpstan-import-type ManagedAgentsWorkflowRunResultErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultErrorObject
 * @phpstan-import-type ManagedAgentsWorkflowRunResultStoppedShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResultStopped
 *
 * @phpstan-type ManagedAgentsWorkflowRunResultVariants = ManagedAgentsWorkflowRunResultCompleted|ManagedAgentsWorkflowRunResultErrorObject|ManagedAgentsWorkflowRunResultStopped
 * @phpstan-type ManagedAgentsWorkflowRunResultShape = ManagedAgentsWorkflowRunResultVariants|ManagedAgentsWorkflowRunResultCompletedShape|ManagedAgentsWorkflowRunResultErrorObjectShape|ManagedAgentsWorkflowRunResultStoppedShape
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
            'error' => ManagedAgentsWorkflowRunResultErrorObject::class,
            'stopped' => ManagedAgentsWorkflowRunResultStopped::class,
        ];
    }
}
