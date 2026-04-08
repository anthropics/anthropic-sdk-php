<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams\Result;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEventParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for confirming or denying a tool execution request.
 *
 * @phpstan-type ManagedAgentsUserToolConfirmationEventParamsShape = array{
 *   result: Result|value-of<Result>,
 *   toolUseID: string,
 *   type: Type|value-of<Type>,
 *   denyMessage?: string|null,
 * }
 */
final class ManagedAgentsUserToolConfirmationEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserToolConfirmationEventParamsShape> */
    use SdkModel;

    /**
     * UserToolConfirmationResult enum.
     *
     * @var value-of<Result> $result
     */
    #[Required(enum: Result::class)]
    public string $result;

    /**
     * The id of the `agent.tool_use` or `agent.mcp_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('tool_use_id')]
    public string $toolUseID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Optional message providing context for a 'deny' decision. Only allowed when result is 'deny'.
     */
    #[Optional('deny_message', nullable: true)]
    public ?string $denyMessage;

    /**
     * `new ManagedAgentsUserToolConfirmationEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserToolConfirmationEventParams::with(
     *   result: ..., toolUseID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserToolConfirmationEventParams)
     *   ->withResult(...)
     *   ->withToolUseID(...)
     *   ->withType(...)
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
     * @param Result|value-of<Result> $result
     * @param Type|value-of<Type> $type
     */
    public static function with(
        Result|string $result,
        string $toolUseID,
        Type|string $type,
        ?string $denyMessage = null,
    ): self {
        $self = new self;

        $self['result'] = $result;
        $self['toolUseID'] = $toolUseID;
        $self['type'] = $type;

        null !== $denyMessage && $self['denyMessage'] = $denyMessage;

        return $self;
    }

    /**
     * UserToolConfirmationResult enum.
     *
     * @param Result|value-of<Result> $result
     */
    public function withResult(Result|string $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * The id of the `agent.tool_use` or `agent.mcp_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Optional message providing context for a 'deny' decision. Only allowed when result is 'deny'.
     */
    public function withDenyMessage(?string $denyMessage): self
    {
        $self = clone $this;
        $self['denyMessage'] = $denyMessage;

        return $self;
    }
}
