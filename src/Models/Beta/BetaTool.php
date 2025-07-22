<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaTool\InputSchema;
use Anthropic\Models\Beta\BetaTool\Type;

/**
 * @phpstan-type beta_tool_alias = array{
 *   inputSchema: InputSchema,
 *   name: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   description?: string,
 *   type?: Type::*|null,
 * }
 */
final class BetaTool implements BaseModel
{
    use Model;

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
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Api(optional: true)]
    public ?string $description;

    /** @var null|Type::* $type */
    #[Api(optional: true)]
    public ?string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|Type::* $type
     */
    final public function __construct(
        InputSchema $inputSchema,
        string $name,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?string $description = null,
        ?string $type = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->inputSchema = $inputSchema;
        $this->name = $name;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $description && $this->description = $description;
        null !== $type && $this->type = $type;
    }
}
