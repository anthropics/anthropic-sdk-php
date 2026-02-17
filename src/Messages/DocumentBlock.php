<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\DocumentBlock\Source;

/**
 * @phpstan-import-type SourceVariants from \Anthropic\Messages\DocumentBlock\Source
 * @phpstan-import-type CitationsConfigShape from \Anthropic\Messages\CitationsConfig
 * @phpstan-import-type SourceShape from \Anthropic\Messages\DocumentBlock\Source
 *
 * @phpstan-type DocumentBlockShape = array{
 *   citations: null|CitationsConfig|CitationsConfigShape,
 *   source: SourceShape,
 *   title: string|null,
 *   type: 'document',
 * }
 */
final class DocumentBlock implements BaseModel
{
    /** @use SdkModel<DocumentBlockShape> */
    use SdkModel;

    /** @var 'document' $type */
    #[Required]
    public string $type = 'document';

    /**
     * Citation configuration for the document.
     */
    #[Required]
    public ?CitationsConfig $citations;

    /** @var SourceVariants $source */
    #[Required(union: Source::class)]
    public Base64PDFSource|PlainTextSource $source;

    /**
     * The title of the document.
     */
    #[Required]
    public ?string $title;

    /**
     * `new DocumentBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentBlock::with(citations: ..., source: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentBlock)->withCitations(...)->withSource(...)->withTitle(...)
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
     * @param CitationsConfig|CitationsConfigShape|null $citations
     * @param SourceShape $source
     */
    public static function with(
        CitationsConfig|array|null $citations,
        Base64PDFSource|array|PlainTextSource $source,
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
     * @param CitationsConfig|CitationsConfigShape|null $citations
     */
    public function withCitations(CitationsConfig|array|null $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    /**
     * @param SourceShape $source
     */
    public function withSource(
        Base64PDFSource|array|PlainTextSource $source
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

    /**
     * @param 'document' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
