<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TextCitationShape from \Anthropic\Messages\TextCitation
 *
 * @phpstan-type TextBlockShape = array{
 *   citations: list<TextCitationShape>|null, text: string, type: 'text'
 * }
 */
final class TextBlock implements BaseModel
{
    /** @use SdkModel<TextBlockShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @var list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null $citations
     */
    #[Required(list: TextCitation::class)]
    public ?array $citations;

    #[Required]
    public string $text;

    /**
     * `new TextBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextBlock::with(citations: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextBlock)->withCitations(...)->withText(...)
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
     * @param list<TextCitationShape>|null $citations
     */
    public static function with(?array $citations, string $text): self
    {
        $self = new self;

        $self['citations'] = $citations;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @param list<TextCitationShape>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
