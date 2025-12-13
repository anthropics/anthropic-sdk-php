<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\DocumentBlockParam\Source;

/**
 * @phpstan-type DocumentBlockParamShape = array{
 *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
 *   type?: 'document',
 *   cacheControl?: CacheControlEphemeral|null,
 *   citations?: CitationsConfigParam|null,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class DocumentBlockParam implements BaseModel
{
    /** @use SdkModel<DocumentBlockParamShape> */
    use SdkModel;

    /** @var 'document' $type */
    #[Required]
    public string $type = 'document';

    #[Required(union: Source::class)]
    public Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Optional(nullable: true)]
    public ?CitationsConfigParam $citations;

    #[Optional(nullable: true)]
    public ?string $context;

    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * `new DocumentBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentBlockParam::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentBlockParam)->withSource(...)
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
     * @param Base64PDFSource|array{
     *   data: string, mediaType?: 'application/pdf', type?: 'base64'
     * }|PlainTextSource|array{
     *   data: string, mediaType?: 'text/plain', type?: 'text'
     * }|ContentBlockSource|array{
     *   content: string|list<TextBlockParam|ImageBlockParam>, type?: 'content'
     * }|URLPDFSource|array{type?: 'url', url: string} $source
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param CitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public static function with(
        Base64PDFSource|array|PlainTextSource|ContentBlockSource|URLPDFSource $source,
        CacheControlEphemeral|array|null $cacheControl = null,
        CitationsConfigParam|array|null $citations = null,
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
     * @param Base64PDFSource|array{
     *   data: string, mediaType?: 'application/pdf', type?: 'base64'
     * }|PlainTextSource|array{
     *   data: string, mediaType?: 'text/plain', type?: 'text'
     * }|ContentBlockSource|array{
     *   content: string|list<TextBlockParam|ImageBlockParam>, type?: 'content'
     * }|URLPDFSource|array{type?: 'url', url: string} $source
     */
    public function withSource(
        Base64PDFSource|array|PlainTextSource|ContentBlockSource|URLPDFSource $source,
    ): self {
        $self = clone $this;
        $self['source'] = $source;

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
     * @param CitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public function withCitations(
        CitationsConfigParam|array|null $citations
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
