<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchBlockParamShape = array{
 *   content: BetaRequestDocumentBlock,
 *   type?: 'web_fetch_result',
 *   url: string,
 *   retrievedAt?: string|null,
 * }
 */
final class BetaWebFetchBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebFetchBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_result' $type */
    #[Required]
    public string $type = 'web_fetch_result';

    #[Required]
    public BetaRequestDocumentBlock $content;

    /**
     * Fetched content URL.
     */
    #[Required]
    public string $url;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Optional('retrieved_at', nullable: true)]
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
     *
     * @param BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type?: 'document',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * } $content
     */
    public static function with(
        BetaRequestDocumentBlock|array $content,
        string $url,
        ?string $retrievedAt = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['url'] = $url;

        null !== $retrievedAt && $obj['retrievedAt'] = $retrievedAt;

        return $obj;
    }

    /**
     * @param BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type?: 'document',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * } $content
     */
    public function withContent(BetaRequestDocumentBlock|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    /**
     * Fetched content URL.
     */
    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj['url'] = $url;

        return $obj;
    }

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    public function withRetrievedAt(?string $retrievedAt): self
    {
        $obj = clone $this;
        $obj['retrievedAt'] = $retrievedAt;

        return $obj;
    }
}
