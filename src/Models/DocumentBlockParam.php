<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\DocumentBlockParam\Source;

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
    use Model;

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
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source,
        ?CacheControlEphemeral $cacheControl = null,
        ?CitationsConfigParam $citations = null,
        ?string $context = null,
        ?string $title = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->source = $source;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $citations && $this->citations = $citations;
        null !== $context && $this->context = $context;
        null !== $title && $this->title = $title;
    }
}
