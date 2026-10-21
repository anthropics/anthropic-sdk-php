<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * URL-based MCP server connection as returned in API responses.
 *
 * @phpstan-type BetaManagedAgentsMCPServerURLDefinitionShape = array{
 *   name: string, type: 'url', url: string
 * }
 */
final class BetaManagedAgentsMCPServerURLDefinition implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPServerURLDefinitionShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Required(type: new ConstantOf('url'))]
    public string $type = 'url';

    #[Required]
    public string $name;

    #[Required]
    public string $url;

    /**
     * `new BetaManagedAgentsMCPServerURLDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPServerURLDefinition::with(name: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPServerURLDefinition())->withName(...)->withURL(...)
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
    public static function with(string $name, string $url): self
    {
        $self = new self;

        $self['name'] = $name;
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
     * @param 'url' $type
     */
    public function withType(string $type): self
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
