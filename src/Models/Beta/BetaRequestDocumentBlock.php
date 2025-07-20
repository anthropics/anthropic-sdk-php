<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRequestDocumentBlock\Source;

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

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?BetaCitationsConfigParam $citations;

    #[Api(optional: true)]
    public ?string $context;

    #[Api(optional: true)]
    public ?string $title;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
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
