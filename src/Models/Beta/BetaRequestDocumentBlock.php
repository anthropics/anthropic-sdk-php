<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRequestDocumentBlock\Type;

final class BetaRequestDocumentBlock implements BaseModel
{
    use Model;

    #[Api]
    public BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source;

    /** @var Type::* $type */
    #[Api]
    public string $type;

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
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
        ?string $context = null,
        ?string $title = null,
    ) {
        $this->source = $source;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
        $this->context = $context;
        $this->title = $title;
    }
}

BetaRequestDocumentBlock::_loadMetadata();
