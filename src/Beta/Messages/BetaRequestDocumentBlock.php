<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_request_document_block_alias = array{
 *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   citations?: BetaCitationsConfigParam,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class BetaRequestDocumentBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'document';

    #[Api(union: Source::class)]
    public BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?BetaCitationsConfigParam $citations;

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
        BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source,
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

    public function setSource(
        BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source,
    ): self {
        $this->source = $source;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    public function setCitations(BetaCitationsConfigParam $citations): self
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
