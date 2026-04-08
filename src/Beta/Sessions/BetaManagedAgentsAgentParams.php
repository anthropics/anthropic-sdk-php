<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Specification for an Agent. Provide a specific `version` or use the short-form `agent="agent_id"` for the most recent version.
 *
 * @phpstan-type BetaManagedAgentsAgentParamsShape = array{
 *   id: string, type: Type|value-of<Type>, version?: int|null
 * }
 */
final class BetaManagedAgentsAgentParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentParamsShape> */
    use SdkModel;

    /**
     * The `agent` ID.
     */
    #[Required]
    public string $id;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * The specific `agent` version to use. Omit to use the latest version. Must be at least 1 if specified.
     */
    #[Optional]
    public ?int $version;

    /**
     * `new BetaManagedAgentsAgentParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentParams::with(id: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentParams)->withID(...)->withType(...)
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
    public static function with(
        string $id,
        Type|string $type,
        ?int $version = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;

        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * The `agent` ID.
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

    /**
     * The specific `agent` version to use. Omit to use the latest version. Must be at least 1 if specified.
     */
    public function withVersion(int $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
