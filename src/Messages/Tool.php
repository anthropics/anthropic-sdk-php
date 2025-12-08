<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\Tool\InputSchema;
use Anthropic\Messages\Tool\Type;

/**
 * @phpstan-type ToolShape = array{
 *   input_schema: InputSchema,
 *   name: string,
 *   cache_control?: CacheControlEphemeral|null,
 *   description?: string|null,
 *   type?: value-of<Type>|null,
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
    #[Required]
    public InputSchema $input_schema;

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
    #[Optional(nullable: true)]
    public ?CacheControlEphemeral $cache_control;

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
     * Tool::with(input_schema: ..., name: ...)
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
     * @param InputSchema|array{
     *   type: 'object',
     *   properties?: array<string,mixed>|null,
     *   required?: list<string>|null,
     * } $input_schema
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        InputSchema|array $input_schema,
        string $name,
        CacheControlEphemeral|array|null $cache_control = null,
        ?string $description = null,
        Type|string|null $type = null,
    ): self {
        $obj = new self;

        $obj['input_schema'] = $input_schema;
        $obj['name'] = $name;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $description && $obj['description'] = $description;
        null !== $type && $obj['type'] = $type;

        return $obj;
    }

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     *
     * @param InputSchema|array{
     *   type: 'object',
     *   properties?: array<string,mixed>|null,
     *   required?: list<string>|null,
     * } $inputSchema
     */
    public function withInputSchema(InputSchema|array $inputSchema): self
    {
        $obj = clone $this;
        $obj['input_schema'] = $inputSchema;

        return $obj;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    public function withDescription(string $description): self
    {
        $obj = clone $this;
        $obj['description'] = $description;

        return $obj;
    }

    /**
     * @param Type|value-of<Type>|null $type
     */
    public function withType(Type|string|null $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }
}
