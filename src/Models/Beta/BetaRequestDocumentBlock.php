<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRequestDocumentBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'document';

    #[Api]
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
        $this->source = $source;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
        $this->context = $context;
        $this->title = $title;
    }
}

BetaRequestDocumentBlock::__introspect();
