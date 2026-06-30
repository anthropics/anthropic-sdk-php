<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaManagedAgentsAgentMessagePreviewShape = array{
 *   id: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsAgentMessagePreview implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentMessagePreviewShape> */
    use SdkModel;

    /**
     * The id the buffered agent.message will carry if it is emitted. Matches the event_id on this preview's event_delta events.
     */
    #[Required]
    public string $id;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAgentMessagePreview()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentMessagePreview::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentMessagePreview)->withID(...)->withType(...)
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
     */
    public static function with(string $id, Type|string $type): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The id the buffered agent.message will carry if it is emitted. Matches the event_id on this preview's event_delta events.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
