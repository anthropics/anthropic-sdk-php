<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_fetch_block = array{
 *   content: BetaDocumentBlock,
 *   retrievedAt: string|null,
 *   type: string,
 *   url: string,
 * }
 */
final class BetaWebFetchBlock implements BaseModel
{
    /** @use SdkModel<beta_web_fetch_block> */
    use SdkModel;

    #[Api]
    public string $type = 'web_fetch_result';

    #[Api]
    public BetaDocumentBlock $content;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Api('retrieved_at')]
    public ?string $retrievedAt;

    /**
     * Fetched content URL.
     */
    #[Api]
    public string $url;

    /**
     * `new BetaWebFetchBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchBlock::with(content: ..., retrievedAt: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchBlock)->withContent(...)->withRetrievedAt(...)->withURL(...)
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
     */
    public static function with(
        BetaDocumentBlock $content,
        ?string $retrievedAt,
        string $url
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->retrievedAt = $retrievedAt;
        $obj->url = $url;

        return $obj;
    }

    public function withContent(BetaDocumentBlock $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    public function withRetrievedAt(?string $retrievedAt): self
    {
        $obj = clone $this;
        $obj->retrievedAt = $retrievedAt;

        return $obj;
    }

    /**
     * Fetched content URL.
     */
    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj->url = $url;

        return $obj;
    }
}
