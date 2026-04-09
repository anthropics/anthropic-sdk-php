<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaAdvisorTool20260301\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaAdvisorTool20260301Shape = array{
 *   model: string|Model|value-of<Model>,
 *   name: 'advisor',
 *   type: 'advisor_20260301',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   caching?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   deferLoading?: bool|null,
 *   maxUses?: int|null,
 *   strict?: bool|null,
 * }
 */
final class BetaAdvisorTool20260301 implements BaseModel
{
    /** @use SdkModel<BetaAdvisorTool20260301Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'advisor' $name
     */
    #[Required]
    public string $name = 'advisor';

    /** @var 'advisor_20260301' $type */
    #[Required]
    public string $type = 'advisor_20260301';

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Caching for the advisor's own prompt. When set, each advisor call writes a cache entry at the given TTL so subsequent calls in the same conversation read the stable prefix. When omitted, the advisor prompt is not cached.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $caching;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Optional('max_uses', nullable: true)]
    public ?int $maxUses;

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    #[Optional]
    public ?bool $strict;

    /**
     * `new BetaAdvisorTool20260301()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorTool20260301::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorTool20260301)->withModel(...)
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
     * @param string|Model|value-of<Model> $model
     * @param list<AllowedCaller|value-of<AllowedCaller>>|null $allowedCallers
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $caching
     */
    public static function with(
        Model|string $model,
        ?array $allowedCallers = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaCacheControlEphemeral|array|null $caching = null,
        ?bool $deferLoading = null,
        ?int $maxUses = null,
        ?bool $strict = null,
    ): self {
        $self = new self;

        $self['model'] = $model;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $caching && $self['caching'] = $caching;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $maxUses && $self['maxUses'] = $maxUses;
        null !== $strict && $self['strict'] = $strict;

        return $self;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @param 'advisor' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'advisor_20260301' $type
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Caching for the advisor's own prompt. When set, each advisor call writes a cache entry at the given TTL so subsequent calls in the same conversation read the stable prefix. When omitted, the advisor prompt is not cached.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $caching
     */
    public function withCaching(
        BetaCacheControlEphemeral|array|null $caching
    ): self {
        $self = clone $this;
        $self['caching'] = $caching;

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
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $self = clone $this;
        $self['maxUses'] = $maxUses;

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
