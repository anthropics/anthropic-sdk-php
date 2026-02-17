<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;
use Anthropic\Messages\ToolBash20250124\AllowedCaller;

/**
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolBash20250124Shape = array{
 *   name: 'bash',
 *   type: 'bash_20250124',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   deferLoading?: bool|null,
 *   inputExamples?: list<array<string,mixed>>|null,
 *   strict?: bool|null,
 * }
 */
final class ToolBash20250124 implements BaseModel
{
    /** @use SdkModel<ToolBash20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'bash' $name
     */
    #[Required]
    public string $name = 'bash';

    /** @var 'bash_20250124' $type */
    #[Required]
    public string $type = 'bash_20250124';

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    /** @var list<array<string,mixed>>|null $inputExamples */
    #[Optional('input_examples', list: new MapOf('mixed'))]
    public ?array $inputExamples;

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    #[Optional]
    public ?bool $strict;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AllowedCaller|value-of<AllowedCaller>>|null $allowedCallers
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param list<array<string,mixed>>|null $inputExamples
     */
    public static function with(
        ?array $allowedCallers = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $inputExamples && $self['inputExamples'] = $inputExamples;
        null !== $strict && $self['strict'] = $strict;

        return $self;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @param 'bash' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'bash_20250124' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

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
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
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
     * @param list<array<string,mixed>> $inputExamples
     */
    public function withInputExamples(array $inputExamples): self
    {
        $self = clone $this;
        $self['inputExamples'] = $inputExamples;

        return $self;
    }

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }
}
