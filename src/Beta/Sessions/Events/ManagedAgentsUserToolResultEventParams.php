<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for providing the result of an agent-toolset tool execution. Only valid on `self_hosted` environments, where sandbox-routed tools are executed by the client rather than the server.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolResultEventParams\Content
 *
 * @phpstan-type ManagedAgentsUserToolResultEventParamsShape = array{
 *   toolUseID: string,
 *   type: 'user.tool_result',
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 * }
 */
final class ManagedAgentsUserToolResultEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserToolResultEventParamsShape> */
    use SdkModel;

    /** @var 'user.tool_result' $type */
    #[Required(type: new ConstantOf('user.tool_result'))]
    public string $type = 'user.tool_result';

    /**
     * The id of the `agent.tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    #[Required('tool_use_id')]
    public string $toolUseID;

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
     * `new ManagedAgentsUserToolResultEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserToolResultEventParams::with(toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserToolResultEventParams())->withToolUseID(...)
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
     * @param list<ContentShape>|null $content
     */
    public static function with(
        string $toolUseID,
        ?array $content = null,
        ?bool $isError = null
    ): self {
        $self = new self;

        $self['toolUseID'] = $toolUseID;

        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;

        return $self;
    }

    /**
     * The id of the `agent.tool_use` event this result corresponds to, which can be found in the last `session.status_idle` [event's](https://platform.claude.com/docs/en/api/beta/sessions/events/list#beta_managed_agents_session_requires_action.event_ids) `stop_reason.event_ids` field.
     */
    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'user.tool_result' $type
     */
    public function withType(string $type): self
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
