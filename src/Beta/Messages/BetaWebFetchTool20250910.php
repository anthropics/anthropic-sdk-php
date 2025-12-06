<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaWebFetchTool20250910\AllowedCaller;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchTool20250910Shape = array{
 *   name: 'web_fetch',
 *   type: 'web_fetch_20250910',
 *   allowed_callers?: list<value-of<AllowedCaller>>|null,
 *   allowed_domains?: list<string>|null,
 *   blocked_domains?: list<string>|null,
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 *   defer_loading?: bool|null,
 *   max_content_tokens?: int|null,
 *   max_uses?: int|null,
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
    #[Api]
    public string $name = 'web_fetch';

    /** @var 'web_fetch_20250910' $type */
    #[Api]
    public string $type = 'web_fetch_20250910';

    /** @var list<value-of<AllowedCaller>>|null $allowed_callers */
    #[Api(list: AllowedCaller::class, optional: true)]
    public ?array $allowed_callers;

    /**
     * List of domains to allow fetching from.
     *
     * @var list<string>|null $allowed_domains
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $allowed_domains;

    /**
     * List of domains to block fetching from.
     *
     * @var list<string>|null $blocked_domains
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $blocked_domains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * Citations configuration for fetched documents. Citations are disabled by default.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * If true, tool will not be included in initial system prompt. Only loaded when returned via tool_reference from tool search.
     */
    #[Api(optional: true)]
    public ?bool $defer_loading;

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $max_content_tokens;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $max_uses;

    #[Api(optional: true)]
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
     * @param list<AllowedCaller|value-of<AllowedCaller>> $allowed_callers
     * @param list<string>|null $allowed_domains
     * @param list<string>|null $blocked_domains
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param BetaCitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public static function with(
        ?array $allowed_callers = null,
        ?array $allowed_domains = null,
        ?array $blocked_domains = null,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        BetaCitationsConfigParam|array|null $citations = null,
        ?bool $defer_loading = null,
        ?int $max_content_tokens = null,
        ?int $max_uses = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        null !== $allowed_callers && $obj['allowed_callers'] = $allowed_callers;
        null !== $allowed_domains && $obj['allowed_domains'] = $allowed_domains;
        null !== $blocked_domains && $obj['blocked_domains'] = $blocked_domains;
        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $citations && $obj['citations'] = $citations;
        null !== $defer_loading && $obj['defer_loading'] = $defer_loading;
        null !== $max_content_tokens && $obj['max_content_tokens'] = $max_content_tokens;
        null !== $max_uses && $obj['max_uses'] = $max_uses;
        null !== $strict && $obj['strict'] = $strict;

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
     * List of domains to allow fetching from.
     *
     * @param list<string>|null $allowedDomains
     */
    public function withAllowedDomains(?array $allowedDomains): self
    {
        $obj = clone $this;
        $obj['allowed_domains'] = $allowedDomains;

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
        $obj['blocked_domains'] = $blockedDomains;

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
        $obj['defer_loading'] = $deferLoading;

        return $obj;
    }

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $obj = clone $this;
        $obj['max_content_tokens'] = $maxContentTokens;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj['max_uses'] = $maxUses;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj['strict'] = $strict;

        return $obj;
    }
}
