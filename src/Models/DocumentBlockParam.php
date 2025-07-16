<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class DocumentBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'document';

    #[Api]
    public Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source;

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
        $this->source = $source;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
        $this->context = $context;
        $this->title = $title;
    }
}

DocumentBlockParam::_loadMetadata();
