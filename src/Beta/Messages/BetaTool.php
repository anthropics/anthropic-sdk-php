<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTool\InputSchema;
use Anthropic\Beta\Messages\BetaTool\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolShape = array{
 *   input_schema: InputSchema,
 *   name: string,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   description?: string|null,
 *   type?: value-of<Type>|null,
 * }
 */
final class BetaTool implements BaseModel
{
    /** @use SdkModel<BetaToolShape> */
    use SdkModel;

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     */
    #[Api]
    public InputSchema $input_schema;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Api(optional: true)]
    public ?string $description;

    /** @var value-of<Type>|null $type */
    #[Api(enum: Type::class, nullable: true, optional: true)]
    public ?string $type;

    /**
     * `new BetaTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTool::with(input_schema: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTool)->withInputSchema(...)->withName(...)
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
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        InputSchema $input_schema,
        string $name,
        ?BetaCacheControlEphemeral $cache_control = null,
        ?string $description = null,
        Type|string|null $type = null,
    ): self {
        $obj = new self;

        $obj->input_schema = $input_schema;
        $obj->name = $name;

        null !== $cache_control && $obj->cache_control = $cache_control;
        null !== $description && $obj->description = $description;
        null !== $type && $obj['type'] = $type;

        return $obj;
    }

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     */
    public function withInputSchema(InputSchema $inputSchema): self
    {
        $obj = clone $this;
        $obj->input_schema = $inputSchema;

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
        $obj->name = $name;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

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
        $obj->description = $description;

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
