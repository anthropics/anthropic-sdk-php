<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaTool\AllowedCaller;
use Anthropic\Beta\Messages\BetaTool\InputSchema;
use Anthropic\Beta\Messages\BetaTool\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolShape = array{
 *   input_schema: InputSchema,
 *   name: string,
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   defer_loading?: bool|null,
 *   description?: string|null,
 *   input_examples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
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

    /** @var list<value-of<AllowedCaller>>|null $allowed_callers */
    #[Api(list: AllowedCaller::class, optional: true)]
    public ?array $allowed_callers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Api(optional: true)]
    public ?bool $defer_loading;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Api(optional: true)]
    public ?string $description;

    /** @var list<array<string,mixed>>|null $input_examples */
    #[Api(list: new MapOf('mixed'), optional: true)]
    public ?array $input_examples;

    #[Api(optional: true)]
    public ?bool $strict;

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
     * @param InputSchema|array{
     *   type: 'object',
     *   properties?: array<string,mixed>|null,
     *   required?: list<string>|null,
     * } $input_schema
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param list<array<string,mixed>> $input_examples
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        InputSchema|array $input_schema,
        string $name,
        ?array $allowed_callers = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?bool $defer_loading = null,
        ?string $description = null,
        ?array $input_examples = null,
        ?bool $strict = null,
        Type|string|null $type = null,
    ): self {
        $obj = new self;

        $obj['input_schema'] = $input_schema;
        $obj['name'] = $name;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $description && $obj['description'] = $description;
        null !== $input_examples && $obj['input_examples'] = $input_examples;
        null !== $strict && $obj['strict'] = $strict;
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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $obj = clone $this;
        $obj['allowed_callers'] = $allowedCallers;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['defer_loading'] = $deferLoading;

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
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $obj = clone $this;
        $obj['input_examples'] = $inputExamples;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

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
