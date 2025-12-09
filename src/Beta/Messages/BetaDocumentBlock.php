<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaDocumentBlock\Source;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaDocumentBlockShape = array{
 *   citations: BetaCitationConfig|null,
 *   source: BetaBase64PDFSource|BetaPlainTextSource,
 *   title: string|null,
 *   type?: 'document',
 * }
 */
final class BetaDocumentBlock implements BaseModel
{
    /** @use SdkModel<BetaDocumentBlockShape> */
    use SdkModel;

    /** @var 'document' $type */
    #[Required]
    public string $type = 'document';

    /**
     * Citation configuration for the document.
     */
    #[Required]
    public ?BetaCitationConfig $citations;

    #[Required(union: Source::class)]
    public BetaBase64PDFSource|BetaPlainTextSource $source;

    /**
     * The title of the document.
     */
    #[Required]
    public ?string $title;

    /**
     * `new BetaDocumentBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDocumentBlock::with(citations: ..., source: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDocumentBlock)->withCitations(...)->withSource(...)->withTitle(...)
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
     * @param BetaCitationConfig|array{enabled: bool}|null $citations
     * @param BetaBase64PDFSource|array{
     *   data: string, mediaType?: 'application/pdf', type?: 'base64'
     * }|BetaPlainTextSource|array{
     *   data: string, mediaType?: 'text/plain', type?: 'text'
     * } $source
     */
    public static function with(
        BetaCitationConfig|array|null $citations,
        BetaBase64PDFSource|array|BetaPlainTextSource $source,
        ?string $title,
    ): self {
        $self = new self;

        $self['citations'] = $citations;
        $self['source'] = $source;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Citation configuration for the document.
     *
     * @param BetaCitationConfig|array{enabled: bool}|null $citations
     */
    public function withCitations(
        BetaCitationConfig|array|null $citations
    ): self {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    /**
     * @param BetaBase64PDFSource|array{
     *   data: string, mediaType?: 'application/pdf', type?: 'base64'
     * }|BetaPlainTextSource|array{
     *   data: string, mediaType?: 'text/plain', type?: 'text'
     * } $source
     */
    public function withSource(
        BetaBase64PDFSource|array|BetaPlainTextSource $source
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The title of the document.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
