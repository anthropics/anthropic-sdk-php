<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An agent response event in the session conversation.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content
 *
 * @phpstan-type ManagedAgentsAgentMessageEventShape = array{
 *   id: string,
 *   content: list<ContentShape>,
 *   processedAt: \DateTimeInterface,
 *   type: 'agent.message',
 * }
 */
final class ManagedAgentsAgentMessageEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentMessageEventShape> */
    use SdkModel;

    /** @var 'agent.message' $type */
    #[Required(type: new ConstantOf('agent.message'))]
    public string $type = 'agent.message';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Array of text blocks comprising the agent response.
     *
     * @var list<ContentVariants> $content
     */
    #[Required(list: Content::class)]
    public array $content;

    /**
     * Timestamp when this response was generated.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsAgentMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentMessageEvent::with(id: ..., content: ..., processedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentMessageEvent())
     *   ->withID(...)
     *   ->withContent(...)
     *   ->withProcessedAt(...)
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
     * @param list<ContentShape> $content
     */
    public static function with(
        string $id,
        array $content,
        \DateTimeInterface $processedAt
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['content'] = $content;
        $self['processedAt'] = $processedAt;

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
     * Array of text blocks comprising the agent response.
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
     * Timestamp when this response was generated.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'agent.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
