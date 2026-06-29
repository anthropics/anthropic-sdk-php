<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebFetchTool20260318\AllowedCaller;
use Anthropic\Beta\Messages\BetaWebFetchTool20260318\ResponseInclusion;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaCitationsConfigParamShape from \Anthropic\Beta\Messages\BetaCitationsConfigParam
 *
 * @phpstan-type BetaWebFetchTool20260318Shape = array{
 *   name: 'web_fetch',
 *   type: 'web_fetch_20260318',
 *   allowedCallers?: list<AllowedCaller|value-of<AllowedCaller>>|null,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   citations?: null|BetaCitationsConfigParam|BetaCitationsConfigParamShape,
 *   deferLoading?: bool|null,
 *   maxContentTokens?: int|null,
 *   maxUses?: int|null,
 *   responseInclusion?: null|ResponseInclusion|value-of<ResponseInclusion>,
 *   strict?: bool|null,
 *   useCache?: bool|null,
 * }
 */
final class BetaWebFetchTool20260318 implements BaseModel
{
    /** @use SdkModel<BetaWebFetchTool20260318Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var 'web_fetch' $name
     */
    #[Required]
    public string $name = 'web_fetch';

    /** @var 'web_fetch_20260318' $type */
    #[Required]
    public string $type = 'web_fetch_20260318';

    /** @var list<value-of<AllowedCaller>>|null $allowedCallers */
    #[Optional('allowed_callers', list: AllowedCaller::class)]
    public ?array $allowedCallers;

    /**
     * List of domains to allow fetching from.
     *
     * @var list<string>|null $allowedDomains
     */
    #[Optional('allowed_domains', list: 'string', nullable: true)]
    public ?array $allowedDomains;

    /**
     * List of domains to block fetching from.
     *
     * @var list<string>|null $blockedDomains
     */
    #[Optional('blocked_domains', list: 'string', nullable: true)]
    public ?array $blockedDomains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Citations configuration for fetched documents. Citations are disabled by default.
     */
    #[Optional(nullable: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    #[Optional('max_content_tokens', nullable: true)]
    public ?int $maxContentTokens;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Optional('max_uses', nullable: true)]
    public ?int $maxUses;

    /**
     * How this tool's result blocks appear in the API response when the result was consumed by a completed code_execution call in the same turn. 'full' returns the complete content (default). 'excluded' drops the nested server_tool_use and result block pair entirely. Results from direct calls, or from code_execution calls that paused before completing, are always returned in full so they can be sent back on the next turn.
     *
     * @var value-of<ResponseInclusion>|null $responseInclusion
     */
    #[Optional('response_inclusion', enum: ResponseInclusion::class)]
    public ?string $responseInclusion;

    /**
     * When true, guarantees schema validation on tool names and inputs.
     */
    #[Optional]
    public ?bool $strict;

    /**
     * Whether to use cached content. Set to false to bypass the cache and fetch fresh content. Only set to false when the user explicitly requests fresh content or when fetching rapidly-changing sources.
     */
    #[Optional('use_cache')]
    public ?bool $useCache;

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
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param BetaCitationsConfigParam|BetaCitationsConfigParamShape|null $citations
     * @param ResponseInclusion|value-of<ResponseInclusion>|null $responseInclusion
     */
    public static function with(
        ?array $allowedCallers = null,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaCitationsConfigParam|array|null $citations = null,
        ?bool $deferLoading = null,
        ?int $maxContentTokens = null,
        ?int $maxUses = null,
        ResponseInclusion|string|null $responseInclusion = null,
        ?bool $strict = null,
        ?bool $useCache = null,
    ): self {
        $self = new self;

        null !== $allowedCallers && $self['allowedCallers'] = $allowedCallers;
        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $citations && $self['citations'] = $citations;
        null !== $deferLoading && $self['deferLoading'] = $deferLoading;
        null !== $maxContentTokens && $self['maxContentTokens'] = $maxContentTokens;
        null !== $maxUses && $self['maxUses'] = $maxUses;
        null !== $responseInclusion && $self['responseInclusion'] = $responseInclusion;
        null !== $strict && $self['strict'] = $strict;
        null !== $useCache && $self['useCache'] = $useCache;

        return $self;
    }

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @param 'web_fetch' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'web_fetch_20260318' $type
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
     * List of domains to allow fetching from.
     *
     * @param list<string>|null $allowedDomains
     */
    public function withAllowedDomains(?array $allowedDomains): self
    {
        $self = clone $this;
        $self['allowedDomains'] = $allowedDomains;

        return $self;
    }

    /**
     * List of domains to block fetching from.
     *
     * @param list<string>|null $blockedDomains
     */
    public function withBlockedDomains(?array $blockedDomains): self
    {
        $self = clone $this;
        $self['blockedDomains'] = $blockedDomains;

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
     * Citations configuration for fetched documents. Citations are disabled by default.
     *
     * @param BetaCitationsConfigParam|BetaCitationsConfigParamShape|null $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array|null $citations
    ): self {
        $self = clone $this;
        $self['citations'] = $citations;

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
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $self = clone $this;
        $self['maxContentTokens'] = $maxContentTokens;

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
     * How this tool's result blocks appear in the API response when the result was consumed by a completed code_execution call in the same turn. 'full' returns the complete content (default). 'excluded' drops the nested server_tool_use and result block pair entirely. Results from direct calls, or from code_execution calls that paused before completing, are always returned in full so they can be sent back on the next turn.
     *
     * @param ResponseInclusion|value-of<ResponseInclusion> $responseInclusion
     */
    public function withResponseInclusion(
        ResponseInclusion|string $responseInclusion
    ): self {
        $self = clone $this;
        $self['responseInclusion'] = $responseInclusion;

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

    /**
     * Whether to use cached content. Set to false to bypass the cache and fetch fresh content. Only set to false when the user explicitly requests fresh content or when fetching rapidly-changing sources.
     */
    public function withUseCache(bool $useCache): self
    {
        $self = clone $this;
        $self['useCache'] = $useCache;

        return $self;
    }
}
