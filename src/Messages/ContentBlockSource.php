<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ContentBlockSource\Content;

/**
 * @phpstan-type ContentBlockSourceShape = array{
 *   content: string|list<TextBlockParam|ImageBlockParam>, type: 'content'
 * }
 */
final class ContentBlockSource implements BaseModel
{
    /** @use SdkModel<ContentBlockSourceShape> */
    use SdkModel;

    /** @var 'content' $type */
    #[Api]
    public string $type = 'content';

    /** @var string|list<TextBlockParam|ImageBlockParam> $content */
    #[Api(union: Content::class)]
    public string|array $content;

    /**
     * `new ContentBlockSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContentBlockSource::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContentBlockSource)->withContent(...)
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
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type: 'image',
     *   cache_control?: CacheControlEphemeral|null,
     * }> $content
     */
    public static function with(string|array $content): self
    {
        $obj = new self;

        $obj['content'] = $content;

        return $obj;
    }

    /**
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type: 'image',
     *   cache_control?: CacheControlEphemeral|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }
}
