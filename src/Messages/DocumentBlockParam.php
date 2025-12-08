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
 *   type: 'document',
 *   cache_control?: CacheControlEphemeral|null,
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
    #[Optional(nullable: true)]
    public ?CacheControlEphemeral $cache_control;

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
     *   data: string, media_type: 'application/pdf', type: 'base64'
     * }|PlainTextSource|array{
     *   data: string, media_type: 'text/plain', type: 'text'
     * }|ContentBlockSource|array{
     *   content: string|list<TextBlockParam|ImageBlockParam>, type: 'content'
     * }|URLPDFSource|array{type: 'url', url: string} $source
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param CitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public static function with(
        Base64PDFSource|array|PlainTextSource|ContentBlockSource|URLPDFSource $source,
        CacheControlEphemeral|array|null $cache_control = null,
        CitationsConfigParam|array|null $citations = null,
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
     * @param Base64PDFSource|array{
     *   data: string, media_type: 'application/pdf', type: 'base64'
     * }|PlainTextSource|array{
     *   data: string, media_type: 'text/plain', type: 'text'
     * }|ContentBlockSource|array{
     *   content: string|list<TextBlockParam|ImageBlockParam>, type: 'content'
     * }|URLPDFSource|array{type: 'url', url: string} $source
     */
    public function withSource(
        Base64PDFSource|array|PlainTextSource|ContentBlockSource|URLPDFSource $source,
    ): self {
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * @param CitationsConfigParam|array{enabled?: bool|null}|null $citations
     */
    public function withCitations(
        CitationsConfigParam|array|null $citations
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
