<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\PluginComponent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PluginComponentShape = array{
 *   description: string|null, name: string, type: Type|value-of<Type>
 * }
 */
final class PluginComponent implements BaseModel
{
    /** @use SdkModel<PluginComponentShape> */
    use SdkModel;

    /**
     * What the component declares about itself; always null for MCP servers, hooks, and CLIs.
     */
    #[Required]
    public ?string $description;

    /**
     * The component's name: a skill's, command's or agent's name, an MCP server's key in the manifest, the event a hook runs on, or a CLI's executable.
     */
    #[Required]
    public string $name;

    /**
     * The kind of component.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new PluginComponent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginComponent::with(description: ..., name: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginComponent())->withDescription(...)->withName(...)->withType(...)
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
        ?string $description,
        string $name,
        Type|string $type
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['name'] = $name;
        $self['type'] = $type;

        return $self;
    }

    /**
     * What the component declares about itself; always null for MCP servers, hooks, and CLIs.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The component's name: a skill's, command's or agent's name, an MCP server's key in the manifest, the event a hook runs on, or a CLI's executable.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The kind of component.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
