<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_fetch_block_param = array{
 *   content: BetaRequestDocumentBlock,
 *   type: string,
 *   url: string,
 *   retrievedAt?: string|null,
 * }
 */
final class BetaWebFetchBlockParam implements BaseModel
{
    /** @use SdkModel<beta_web_fetch_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'web_fetch_result';

    #[Api]
    public BetaRequestDocumentBlock $content;

    /**
     * Fetched content URL.
     */
    #[Api]
    public string $url;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Api('retrieved_at', nullable: true, optional: true)]
    public ?string $retrievedAt;

    /**
     * `new BetaWebFetchBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchBlockParam::with(content: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchBlockParam)->withContent(...)->withURL(...)
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
        BetaRequestDocumentBlock $content,
        string $url,
        ?string $retrievedAt = null
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->url = $url;

        null !== $retrievedAt && $obj->retrievedAt = $retrievedAt;

        return $obj;
    }

    public function withContent(BetaRequestDocumentBlock $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

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

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    public function withRetrievedAt(?string $retrievedAt): self
    {
        $obj = clone $this;
        $obj->retrievedAt = $retrievedAt;

        return $obj;
    }
}
