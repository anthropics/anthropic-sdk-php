<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\DocumentBlockParam\Source;

/**
 * @phpstan-type document_block_param_alias = array{
 *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 *   citations?: CitationsConfigParam,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class DocumentBlockParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'document';

    #[Api(union: Source::class)]
    public Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?CitationsConfigParam $citations;

    #[Api(optional: true)]
    public ?string $context;

    #[Api(optional: true)]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source,
        ?CacheControlEphemeral $cacheControl = null,
        ?CitationsConfigParam $citations = null,
        ?string $context = null,
        ?string $title = null,
    ): self {
        $obj = new self;

        $obj->source = $source;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $citations && $obj->citations = $citations;
        null !== $context && $obj->context = $context;
        null !== $title && $obj->title = $title;

        return $obj;
    }

    public function withSource(
        Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source
    ): self {
        $obj = clone $this;
        $obj->source = $source;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withCitations(CitationsConfigParam $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }

    public function withContext(?string $context): self
    {
        $obj = clone $this;
        $obj->context = $context;

        return $obj;
    }

    public function withTitle(?string $title): self
    {
        $obj = clone $this;
        $obj->title = $title;

        return $obj;
    }
}
