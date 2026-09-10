<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The resolved permission_policy was auto: the server judged this invocation individually.
 *
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermission
 * @phpstan-import-type ManagedAgentsAgentAutoEvaluatedPermissionShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentAutoEvaluatedPermission
 *
 * @phpstan-type ManagedAgentsAgentToolEvaluationAutoShape = array{
 *   evaluatedPermission: ManagedAgentsAgentAutoEvaluatedPermissionShape,
 *   type: 'auto',
 * }
 */
final class ManagedAgentsAgentToolEvaluationAuto implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentToolEvaluationAutoShape> */
    use SdkModel;

    /** @var 'auto' $type */
    #[Required]
    public string $type = 'auto';

    /**
     * The server's per-invocation judgement under the auto permission policy. Its type always equals the event's top-level evaluated_permission. Open union: clients must tolerate unknown variants.
     *
     * @var ManagedAgentsAgentAutoEvaluatedPermissionVariants $evaluatedPermission
     */
    #[Required(
        'evaluated_permission',
        union: ManagedAgentsAgentAutoEvaluatedPermission::class,
    )]
    public ManagedAgentsAgentAutoEvaluatedPermissionAllow|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny $evaluatedPermission;

    /**
     * `new ManagedAgentsAgentToolEvaluationAuto()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentToolEvaluationAuto::with(evaluatedPermission: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentToolEvaluationAuto)->withEvaluatedPermission(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ManagedAgentsAgentAutoEvaluatedPermissionShape $evaluatedPermission
     */
    public static function with(
        ManagedAgentsAgentAutoEvaluatedPermissionAllow|array|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny $evaluatedPermission,
    ): self {
        $self = new self;

        $self['evaluatedPermission'] = $evaluatedPermission;

        return $self;
    }

    /**
     * The server's per-invocation judgement under the auto permission policy. Its type always equals the event's top-level evaluated_permission. Open union: clients must tolerate unknown variants.
     *
     * @param ManagedAgentsAgentAutoEvaluatedPermissionShape $evaluatedPermission
     */
    public function withEvaluatedPermission(
        ManagedAgentsAgentAutoEvaluatedPermissionAllow|array|ManagedAgentsAgentAutoEvaluatedPermissionAsk|ManagedAgentsAgentAutoEvaluatedPermissionDeny $evaluatedPermission,
    ): self {
        $self = clone $this;
        $self['evaluatedPermission'] = $evaluatedPermission;

        return $self;
    }

    /**
     * @param 'auto' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
