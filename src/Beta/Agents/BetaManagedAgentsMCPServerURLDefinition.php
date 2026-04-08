<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * URL-based MCP server connection as returned in API responses.
 *
 * @phpstan-type BetaManagedAgentsMCPServerURLDefinitionShape = array{
 *   name: string, type: Type|value-of<Type>, url: string
 * }
 */
final class BetaManagedAgentsMCPServerURLDefinition implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPServerURLDefinitionShape> */
    use SdkModel;

    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    #[Required]
    public string $url;

    /**
     * `new BetaManagedAgentsMCPServerURLDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPServerURLDefinition::with(name: ..., type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPServerURLDefinition)
     *   ->withName(...)
     *   ->withType(...)
     *   ->withURL(...)
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
        string $name,
        Type|string $type,
        string $url
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['type'] = $type;
        $self['url'] = $url;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
