<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaWebFetchTool20250910\AllowedCaller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchTool20250910Shape = array{
 *   name?: 'web_fetch',
 *   type?: 'web_fetch_20250910',
 *   allowedCallers?: list<value-of<AllowedCaller>>|null,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 *   deferLoading?: bool|null,
 *   maxContentTokens?: int|null,
 *   maxUses?: int|null,
 *   strict?: bool|null,
 * }
 */
final class BetaWebFetchTool20250910 implements BaseModel
{
    /** @use SdkModel<BetaWebFetchTool20250910Shape> */
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

    /** @var 'web_fetch_20250910' $type */
    #[Required]
    public string $type = 'web_fetch_20250910';

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
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param BetaCitationsConfigParam|array{enabled?: bool|null}|null $citations
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
        ?bool $strict = null,
    ): self {
        $obj = new self;

        null !== $allowedCallers && $obj['allowedCallers'] = $allowedCallers;
        null !== $allowedDomains && $obj['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $obj['blockedDomains'] = $blockedDomains;
        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $citations && $obj['citations'] = $citations;
        null !== $deferLoading && $obj['deferLoading'] = $deferLoading;
        null !== $maxContentTokens && $obj['maxContentTokens'] = $maxContentTokens;
        null !== $maxUses && $obj['maxUses'] = $maxUses;
        null !== $strict && $obj['strict'] = $strict;

        return $obj;
    }

    /**
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowedCallers
     */
    public function withAllowedCallers(array $allowedCallers): self
    {
        $obj = clone $this;
        $obj['allowedCallers'] = $allowedCallers;

        return $obj;
    }

    /**
     * List of domains to allow fetching from.
     *
     * @param list<string>|null $allowedDomains
     */
    public function withAllowedDomains(?array $allowedDomains): self
    {
        $obj = clone $this;
        $obj['allowedDomains'] = $allowedDomains;

        return $obj;
    }

    /**
     * List of domains to block fetching from.
     *
     * @param list<string>|null $blockedDomains
     */
    public function withBlockedDomains(?array $blockedDomains): self
    {
        $obj = clone $this;
        $obj['blockedDomains'] = $blockedDomains;

        return $obj;
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
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * Citations configuration for fetched documents. Citations are disabled by default.
     *
     * @param BetaCitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array|null $citations
    ): self {
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['deferLoading'] = $deferLoading;

        return $obj;
    }

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $obj = clone $this;
        $obj['maxContentTokens'] = $maxContentTokens;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj['maxUses'] = $maxUses;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
