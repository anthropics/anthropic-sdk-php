<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchTool20250910Shape = array{
 *   name: string,
 *   type: string,
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 *   maxContentTokens?: int|null,
 *   maxUses?: int|null,
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
     */
    #[Api]
    public string $name = 'web_fetch';

    #[Api]
    public string $type = 'web_fetch_20250910';

    /**
     * List of domains to allow fetching from.
     *
     * @var list<string>|null $allowedDomains
     */
    #[Api('allowed_domains', list: 'string', nullable: true, optional: true)]
    public ?array $allowedDomains;

    /**
     * List of domains to block fetching from.
     *
     * @var list<string>|null $blockedDomains
     */
    #[Api('blocked_domains', list: 'string', nullable: true, optional: true)]
    public ?array $blockedDomains;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Citations configuration for fetched documents. Citations are disabled by default.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    #[Api('max_content_tokens', nullable: true, optional: true)]
    public ?int $maxContentTokens;

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    #[Api('max_uses', nullable: true, optional: true)]
    public ?int $maxUses;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     */
    public static function with(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
        ?int $maxContentTokens = null,
        ?int $maxUses = null,
    ): self {
        $obj = new self;

        null !== $allowedDomains && $obj->allowedDomains = $allowedDomains;
        null !== $blockedDomains && $obj->blockedDomains = $blockedDomains;
        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $citations && $obj->citations = $citations;
        null !== $maxContentTokens && $obj->maxContentTokens = $maxContentTokens;
        null !== $maxUses && $obj->maxUses = $maxUses;

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
        $obj->allowedDomains = $allowedDomains;

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
        $obj->blockedDomains = $blockedDomains;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * Citations configuration for fetched documents. Citations are disabled by default.
     */
    public function withCitations(?BetaCitationsConfigParam $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }

    /**
     * Maximum number of tokens used by including web page text content in the context. The limit is approximate and does not apply to binary content such as PDFs.
     */
    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $obj = clone $this;
        $obj->maxContentTokens = $maxContentTokens;

        return $obj;
    }

    /**
     * Maximum number of times the tool can be used in the API request.
     */
    public function withMaxUses(?int $maxUses): self
    {
        $obj = clone $this;
        $obj->maxUses = $maxUses;

        return $obj;
    }
}
