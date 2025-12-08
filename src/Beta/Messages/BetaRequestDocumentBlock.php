<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestDocumentBlockShape = array{
 *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
 *   type: 'document',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class BetaRequestDocumentBlock implements BaseModel
{
    /** @use SdkModel<BetaRequestDocumentBlockShape> */
    use SdkModel;

    /** @var 'document' $type */
    #[Required]
    public string $type = 'document';

    #[Required(union: Source::class)]
    public BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    #[Optional(nullable: true)]
    public ?BetaCitationsConfigParam $citations;

    #[Optional(nullable: true)]
    public ?string $context;

    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * `new BetaRequestDocumentBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestDocumentBlock::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestDocumentBlock)->withSource(...)
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
     * @param BetaBase64PDFSource|array{
     *   data: string, media_type: 'application/pdf', type: 'base64'
     * }|BetaPlainTextSource|array{
     *   data: string, media_type: 'text/plain', type: 'text'
     * }|BetaContentBlockSource|array{
     *   content: string|list<BetaTextBlockParam|BetaImageBlockParam>, type: 'content'
     * }|BetaURLPDFSource|array{type: 'url', url: string}|BetaFileDocumentSource|array{
     *   file_id: string, type: 'file'
     * } $source
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param BetaCitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public static function with(
        BetaBase64PDFSource|array|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        BetaCitationsConfigParam|array|null $citations = null,
        ?string $context = null,
        ?string $title = null,
    ): self {
        $obj = new self;

        $obj['source'] = $source;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $citations && $obj['citations'] = $citations;
        null !== $context && $obj['context'] = $context;
        null !== $title && $obj['title'] = $title;

        return $obj;
    }

    /**
     * @param BetaBase64PDFSource|array{
     *   data: string, media_type: 'application/pdf', type: 'base64'
     * }|BetaPlainTextSource|array{
     *   data: string, media_type: 'text/plain', type: 'text'
     * }|BetaContentBlockSource|array{
     *   content: string|list<BetaTextBlockParam|BetaImageBlockParam>, type: 'content'
     * }|BetaURLPDFSource|array{type: 'url', url: string}|BetaFileDocumentSource|array{
     *   file_id: string, type: 'file'
     * } $source
     */
    public function withSource(
        BetaBase64PDFSource|array|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
    ): self {
        $obj = clone $this;
        $obj['source'] = $source;

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
     * @param BetaCitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array|null $citations
    ): self {
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }

    public function withContext(?string $context): self
    {
        $obj = clone $this;
        $obj['context'] = $context;

        return $obj;
    }

    public function withTitle(?string $title): self
    {
        $obj = clone $this;
        $obj['title'] = $title;

        return $obj;
    }
}
