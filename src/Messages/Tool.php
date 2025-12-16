<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Tool\InputSchema;
use Anthropic\Messages\Tool\Type;

/**
 * @phpstan-import-type InputSchemaShape from \Anthropic\Messages\Tool\InputSchema
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolShape = array{
 *   inputSchema: InputSchema|InputSchemaShape,
 *   name: string,
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   description?: string|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class Tool implements BaseModel
{
    /** @use SdkModel<ToolShape> */
    use SdkModel;

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     */
    #[Required('input_schema')]
    public InputSchema $inputSchema;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Required]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Optional]
    public ?string $description;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class, nullable: true)]
    public ?string $type;

    /**
     * `new Tool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Tool::with(inputSchema: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Tool)->withInputSchema(...)->withName(...)
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
     * @param InputSchemaShape $inputSchema
     * @param CacheControlEphemeralShape|null $cacheControl
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        InputSchema|array $inputSchema,
        string $name,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?string $description = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['inputSchema'] = $inputSchema;
        $self['name'] = $name;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $description && $self['description'] = $description;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     *
     * @param InputSchemaShape $inputSchema
     */
    public function withInputSchema(InputSchema|array $inputSchema): self
    {
        $self = clone $this;
        $self['inputSchema'] = $inputSchema;

        return $self;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * @param Type|value-of<Type>|null $type
     */
    public function withType(Type|string|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
