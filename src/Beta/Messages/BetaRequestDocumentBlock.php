<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestDocumentBlockShape = array{
 *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class BetaRequestDocumentBlock implements BaseModel
{
    /** @use SdkModel<BetaRequestDocumentBlockShape> */
    use SdkModel;

    #[Api]
    public string $type = 'document';

    #[Api(union: Source::class)]
    public BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(nullable: true, optional: true)]
    public ?BetaCitationsConfigParam $citations;

    #[Api(nullable: true, optional: true)]
    public ?string $context;

    #[Api(nullable: true, optional: true)]
    public ?string $title;

    /**
     * `new BetaRequestDocumentBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestDocumentBlock::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestDocumentBlock)->withSource(...)
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
     */
    public static function with(
        BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
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
        BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source,
    ): self {
        $obj = clone $this;
        $obj->source = $source;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withCitations(?BetaCitationsConfigParam $citations): self
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
