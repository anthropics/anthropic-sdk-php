<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaCitationsConfigParamShape from \Anthropic\Beta\Messages\BetaCitationsConfigParam
 *
 * @phpstan-type BetaRequestDocumentBlockShape = array{
 *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource|SourceShape,
 *   type: 'document',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   citations?: null|BetaCitationsConfigParam|BetaCitationsConfigParamShape,
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
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

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
     * @param SourceShape $source
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param BetaCitationsConfigParamShape|null $citations
     */
    public static function with(
        BetaBase64PDFSource|array|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaCitationsConfigParam|array|null $citations = null,
        ?string $context = null,
        ?string $title = null,
    ): self {
        $self = new self;

        $self['source'] = $source;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $citations && $self['citations'] = $citations;
        null !== $context && $self['context'] = $context;
        null !== $title && $self['title'] = $title;

        return $self;
    }

    /**
     * @param SourceShape $source
     */
    public function withSource(
        BetaBase64PDFSource|array|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param BetaCitationsConfigParamShape|null $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array|null $citations
    ): self {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    public function withContext(?string $context): self
    {
        $self = clone $this;
        $self['context'] = $context;

        return $self;
    }

    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
