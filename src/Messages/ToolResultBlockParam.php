<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\ToolResultBlockParam\Content;

/**
 * @phpstan-type ToolResultBlockParamShape = array{
 *   toolUseID: string,
 *   type?: 'tool_result',
 *   cacheControl?: CacheControlEphemeral|null,
 *   content?: string|null|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>,
 *   isError?: bool|null,
 * }
 */
final class ToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<ToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_result' $type */
    #[Required]
    public string $type = 'tool_result';

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>|null $content
     */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    #[Optional('is_error')]
    public ?bool $isError;

    /**
     * `new ToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolResultBlockParam::with(toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolResultBlockParam)->withToolUseID(...)
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
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type?: 'image',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|SearchResultBlockParam|array{
     *   content: list<TextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     * }|DocumentBlockParam|array{
     *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
     *   type?: 'document',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }> $content
     */
    public static function with(
        string $toolUseID,
        CacheControlEphemeral|array|null $cacheControl = null,
        string|array|null $content = null,
        ?bool $isError = null,
    ): self {
        $self = new self;

        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $content && $self['content'] = $content;
        null !== $isError && $self['isError'] = $isError;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type?: 'image',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|SearchResultBlockParam|array{
     *   content: list<TextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     * }|DocumentBlockParam|array{
     *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
     *   type?: 'document',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withIsError(bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

        return $self;
    }
}
