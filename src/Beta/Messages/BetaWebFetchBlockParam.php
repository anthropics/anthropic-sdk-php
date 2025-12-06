<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchBlockParamShape = array{
 *   content: BetaRequestDocumentBlock,
 *   type: 'web_fetch_result',
 *   url: string,
 *   retrieved_at?: string|null,
 * }
 */
final class BetaWebFetchBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebFetchBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_result' $type */
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
    #[Api(nullable: true, optional: true)]
    public ?string $retrieved_at;

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
     *   type: 'document',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * } $content
     */
    public static function with(
        BetaRequestDocumentBlock|array $content,
        string $url,
        ?string $retrieved_at = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['url'] = $url;

        null !== $retrieved_at && $obj['retrieved_at'] = $retrieved_at;

        return $obj;
    }

    /**
     * @param BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type: 'document',
     *   cache_control?: BetaCacheControlEphemeral|null,
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
        $obj['retrieved_at'] = $retrievedAt;

        return $obj;
    }
}
