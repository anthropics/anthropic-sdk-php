<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Tool\InputSchema;
use Anthropic\Messages\Tool\Type;

/**
 * @phpstan-type tool_alias = array{
 *   inputSchema: InputSchema,
 *   name: string,
 *   cacheControl?: CacheControlEphemeral,
 *   description?: string,
 *   type?: Type::*|null,
 * }
 */
final class Tool implements BaseModel
{
    use ModelTrait;

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     */
    #[Api('input_schema')]
    public InputSchema $inputSchema;

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
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Api(optional: true)]
    public ?string $description;

    /** @var null|Type::* $type */
    #[Api(enum: Type::class, nullable: true, optional: true)]
    public ?string $type;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|Type::* $type
     */
    public static function from(
        InputSchema $inputSchema,
        string $name,
        ?CacheControlEphemeral $cacheControl = null,
        ?string $description = null,
        ?string $type = null,
    ): self {
        $obj = new self;

        $obj->inputSchema = $inputSchema;
        $obj->name = $name;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $description && $obj->description = $description;
        null !== $type && $obj->type = $type;

        return $obj;
    }

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     */
    public function setInputSchema(InputSchema $inputSchema): self
    {
        $this->inputSchema = $inputSchema;

        return $this;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param null|Type::* $type
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
