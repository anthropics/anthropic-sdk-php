<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCodeExecutionTool20250825\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaCodeExecutionTool20250825Shape = array{
 *   name: 'code_execution',
 *   type: 'code_execution_20250825',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   deferLoading?: bool|null,
 *   strict?: bool|null,
 * }
 */
final class BetaCodeExecutionTool20250825 implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionTool20250825Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'code_execution' $name
     */
    #[Required]
    public string $name = 'code_execution';

    /** @var 'code_execution_20250825' $type */
    #[Required]
    public string $type = 'code_execution_20250825';

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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $strict && $self['strict'] = $strict;

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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
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

    public function withStrict(bool $strict): self
    {
        $self = clone $this;
        $self['strict'] = $strict;

        return $self;
    }
}
