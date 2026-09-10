<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The server reached no judgement; the invocation is held for client approval.
 *
 * @phpstan-type ManagedAgentsAgentAutoEvaluatedPermissionAskShape = array{
 *   reasonCode: string, type: 'ask'
 * }
 */
final class ManagedAgentsAgentAutoEvaluatedPermissionAsk implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentAutoEvaluatedPermissionAskShape> */
    use SdkModel;

    /** @var 'ask' $type */
    #[Required]
    public string $type = 'ask';

    /**
     * The judgement's grounds in registry-bound terms, for client branching and audit rather than end-user display. Open registry; currently "indeterminate" (no judgement was reached). Clients must tolerate values outside this set.
     */
    #[Required('reason_code')]
    public string $reasonCode;

    /**
     * `new ManagedAgentsAgentAutoEvaluatedPermissionAsk()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentAutoEvaluatedPermissionAsk::with(reasonCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentAutoEvaluatedPermissionAsk)->withReasonCode(...)
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
     * The judgement's grounds in registry-bound terms, for client branching and audit rather than end-user display. Open registry; currently "indeterminate" (no judgement was reached). Clients must tolerate values outside this set.
     */
    public function withReasonCode(string $reasonCode): self
    {
        $self = clone $this;
        $self['reasonCode'] = $reasonCode;

        return $self;
    }

    /**
     * @param 'ask' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
