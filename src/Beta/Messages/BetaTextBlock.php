<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_text_block_alias = array{
 *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
 *   text: string,
 *   type: string,
 * }
 */
final class BetaTextBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @var null|list<BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation> $citations
     */
    #[Api(type: new ListOf(union: BetaTextCitation::class), nullable: true)]
    public ?array $citations;

    #[Api]
    public string $text;

    /**
     * `new BetaTextBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextBlock::with(citations: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextBlock)->withCitations(...)->withText(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|list<BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation> $citations
     */
    public static function with(?array $citations, string $text): self
    {
        $obj = new self;

        $obj->citations = $citations;
        $obj->text = $text;

        return $obj;
    }

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @param null|list<BetaCitationCharLocation|BetaCitationContentBlockLocation|BetaCitationPageLocation|BetaCitationSearchResultLocation|BetaCitationsWebSearchResultLocation> $citations
     */
    public function withCitations(?array $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }

    public function withText(string $text): self
    {
        $obj = clone $this;
        $obj->text = $text;

        return $obj;
    }
}
