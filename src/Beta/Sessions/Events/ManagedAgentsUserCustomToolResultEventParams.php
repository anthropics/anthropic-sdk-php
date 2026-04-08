<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Content;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for providing the result of a custom tool execution.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEventParams\Content
 *
 * @phpstan-type ManagedAgentsUserCustomToolResultEventParamsShape = array{
 *   customToolUseID: string,
 *   type: Type|value-of<Type>,
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 * }
 */
final class ManagedAgentsUserCustomToolResultEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserCustomToolResultEventParamsShape> */
    use SdkModel;

    /**
     * The id of the `agent.custom_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('custom_tool_use_id')]
    public string $customToolUseID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The result content returned by the tool.
     *
     * @var list<ContentVariants>|null $content
     */
    #[Optional(list: Content::class)]
    public ?array $content;

    /**
     * Whether the tool execution resulted in an error.
     */
    #[Optional('is_error', nullable: true)]
    public ?bool $isError;

    /**
     * `new ManagedAgentsUserCustomToolResultEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserCustomToolResultEventParams::with(
     *   customToolUseID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserCustomToolResultEventParams)
     *   ->withCustomToolUseID(...)
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
     * @param Type|value-of<Type> $type
     * @param list<ContentShape>|null $content
     */
    public static function with(
        string $customToolUseID,
        Type|string $type,
        ?array $content = null,
        ?bool $isError = null,
    ): self {
        $self = new self;

        $self['customToolUseID'] = $customToolUseID;
        $self['type'] = $type;

        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;

        return $self;
    }

    /**
     * The id of the `agent.custom_tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withCustomToolUseID(string $customToolUseID): self
    {
        $self = clone $this;
        $self['customToolUseID'] = $customToolUseID;

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
     * The result content returned by the tool.
     *
     * @param list<ContentShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Whether the tool execution resulted in an error.
     */
    public function withIsError(?bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

        return $self;
    }
}
