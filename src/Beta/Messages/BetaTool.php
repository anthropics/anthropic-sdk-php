<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaTool\AllowedCaller;
use Anthropic\Beta\Messages\BetaTool\InputSchema;
use Anthropic\Beta\Messages\BetaTool\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * @phpstan-type BetaToolShape = array{
 *   inputSchema: InputSchema,
 *   name: string,
 *   allowedCallers?: list<value-of<AllowedCaller>>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   deferLoading?: bool|null,
 *   description?: string|null,
 *   inputExamples?: list<array<string,mixed>>|null,
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
    #[Required('input_schema')]
    public InputSchema $inputSchema;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Required]
    public string $name;

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    /**
     * Description of what this tool does.
     *
     * Tool descriptions should be as detailed as possible. The more information that the model has about what the tool is and how to use it, the better it will perform. You can use natural language descriptions to reinforce important aspects of the tool input JSON schema.
     */
    #[Optional]
    public ?string $description;

    /** @var list<array<string,mixed>>|null $inputExamples */
    #[Optional('input_examples', list: new MapOf('mixed'))]
    public ?array $inputExamples;

    #[Optional]
    public ?bool $strict;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class, nullable: true)]
    public ?string $type;

    /**
     * `new BetaTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTool::with(inputSchema: ..., name: ...)
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
     *   type?: 'object',
     *   properties?: array<string,mixed>|null,
     *   required?: list<string>|null,
     * } $inputSchema
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param list<array<string,mixed>> $inputExamples
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        InputSchema|array $inputSchema,
        string $name,
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?string $description = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['inputSchema'] = $inputSchema;
        $self['name'] = $name;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $description && $self['description'] = $description;
        null !== $inputExamples && $self['inputExamples'] = $inputExamples;
        null !== $strict && $self['strict'] = $strict;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
     *
     * This defines the shape of the `input` that your tool accepts and that the model will produce.
     *
     * @param InputSchema|array{
     *   type?: 'object',
     *   properties?: array<string,mixed>|null,
     *   required?: list<string>|null,
     * } $inputSchema
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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $self = clone $this;
        $self['allowedCallers'] = $allowedCallers;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $self = clone $this;
        $self['deferLoading'] = $deferLoading;

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
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $self = clone $this;
        $self['inputExamples'] = $inputExamples;

        return $self;
    }

    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

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
