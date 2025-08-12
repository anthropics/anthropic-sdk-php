<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
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
    use ModelTrait;

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
    public static function new(
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

    public function setSource(
        Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source
    ): self {
        $this->source = $source;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    public function setCitations(CitationsConfigParam $citations): self
    {
        $this->citations = $citations;

        return $this;
    }

    public function setContext(?string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
