<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchBlockShape = array{
 *   content: BetaDocumentBlock,
 *   retrieved_at: string|null,
 *   type: 'web_fetch_result',
 *   url: string,
 * }
 */
final class BetaWebFetchBlock implements BaseModel
{
    /** @use SdkModel<BetaWebFetchBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_result' $type */
    #[Required]
    public string $type = 'web_fetch_result';

    #[Required]
    public BetaDocumentBlock $content;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Required]
    public ?string $retrieved_at;

    /**
     * Fetched content URL.
     */
    #[Required]
    public string $url;

    /**
     * `new BetaWebFetchBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchBlock::with(content: ..., retrieved_at: ..., url: ...)
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
     *
     * @param BetaDocumentBlock|array{
     *   citations: BetaCitationConfig|null,
     *   source: BetaBase64PDFSource|BetaPlainTextSource,
     *   title: string|null,
     *   type: 'document',
     * } $content
     */
    public static function with(
        BetaDocumentBlock|array $content,
        ?string $retrieved_at,
        string $url
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['retrieved_at'] = $retrieved_at;
        $obj['url'] = $url;

        return $obj;
    }

    /**
     * @param BetaDocumentBlock|array{
     *   citations: BetaCitationConfig|null,
     *   source: BetaBase64PDFSource|BetaPlainTextSource,
     *   title: string|null,
     *   type: 'document',
     * } $content
     */
    public function withContent(BetaDocumentBlock|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

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

    /**
     * Fetched content URL.
     */
    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj['url'] = $url;

        return $obj;
    }
}
