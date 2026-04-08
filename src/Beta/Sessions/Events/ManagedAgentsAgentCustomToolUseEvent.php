<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Event emitted when the agent calls a custom tool. The session goes idle until the client sends a `user.custom_tool_result` event with the result.
 *
 * @phpstan-type ManagedAgentsAgentCustomToolUseEventShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsAgentCustomToolUseEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentCustomToolUseEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Input parameters for the tool call.
     *
     * @var array<string,mixed> $input
     */
    #[Required(map: 'mixed')]
    public array $input;

    /**
     * Name of the custom tool being called.
     */
    #[Required]
    public string $name;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsAgentCustomToolUseEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentCustomToolUseEvent::with(
     *   id: ..., input: ..., name: ..., processedAt: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentCustomToolUseEvent)
     *   ->withID(...)
     *   ->withInput(...)
     *   ->withName(...)
     *   ->withProcessedAt(...)
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
     * @param array<string,mixed> $input
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $input,
        string $name,
        \DateTimeInterface $processedAt,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['name'] = $name;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

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
     * Input parameters for the tool call.
     *
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * Name of the custom tool being called.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

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
}
