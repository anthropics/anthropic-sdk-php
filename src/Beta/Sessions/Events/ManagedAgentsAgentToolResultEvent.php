<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Event representing the result of an agent tool execution.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent\Content
 *
 * @phpstan-type ManagedAgentsAgentToolResultEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   toolUseID: string,
 *   type: 'agent.tool_result',
 *   content?: list<ContentShape>|null,
 *   isError?: bool|null,
 * }
 */
final class ManagedAgentsAgentToolResultEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentToolResultEventShape> */
    use SdkModel;

    /** @var 'agent.tool_result' $type */
    #[Required(type: new ConstantOf('agent.tool_result'))]
    public string $type = 'agent.tool_result';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when this event was processed.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * The id of the `agent.tool_use` event this result corresponds to.
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
     * `new ManagedAgentsAgentToolResultEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentToolResultEvent::with(
     *   id: ..., processedAt: ..., toolUseID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentToolResultEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withToolUseID(...)
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
        string $id,
        \DateTimeInterface $processedAt,
        string $toolUseID,
        ?array $content = null,
        ?bool $isError = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['toolUseID'] = $toolUseID;

        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;

        return $self;
    }

    /**
     * Unique identifier for this event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Timestamp when this event was processed.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * The id of the `agent.tool_use` event this result corresponds to.
     */
    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'agent.tool_result' $type
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
