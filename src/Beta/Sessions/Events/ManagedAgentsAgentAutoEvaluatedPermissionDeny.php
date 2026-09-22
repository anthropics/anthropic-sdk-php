<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The server judged the invocation high-risk; it does not execute and a synthetic error tool result is appended.
 *
 * @phpstan-type ManagedAgentsAgentAutoEvaluatedPermissionDenyShape = array{
 *   reasonCode: string, type: 'deny'
 * }
 */
final class ManagedAgentsAgentAutoEvaluatedPermissionDeny implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentAutoEvaluatedPermissionDenyShape> */
    use SdkModel;

    /** @var 'deny' $type */
    #[Required(type: new ConstantOf('deny'))]
    public string $type = 'deny';

    /**
     * The judgement's grounds in registry-bound terms. Open registry; currently "high_risk" (judged high-risk; the call does not run). Clients must tolerate values outside this set.
     */
    #[Required('reason_code')]
    public string $reasonCode;

    /**
     * `new ManagedAgentsAgentAutoEvaluatedPermissionDeny()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentAutoEvaluatedPermissionDeny::with(reasonCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentAutoEvaluatedPermissionDeny)->withReasonCode(...)
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
     */
    public static function with(string $reasonCode): self
    {
        $self = new self;

        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * The judgement's grounds in registry-bound terms. Open registry; currently "high_risk" (judged high-risk; the call does not run). Clients must tolerate values outside this set.
     */
    public function withReasonCode(string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * @param 'deny' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
