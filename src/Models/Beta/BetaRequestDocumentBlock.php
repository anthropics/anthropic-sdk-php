<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

final class BetaRequestDocumentBlock implements BaseModel
{
    use Model;

    /**
     * @var BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source
     */
    #[Api]
    public mixed $source;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaBase64PDFSource|BetaContentBlockSource|BetaFileDocumentSource|BetaPlainTextSource|BetaURLPDFSource $source       `required`
     * @param string                                                                                                 $type         `required`
     * @param BetaCacheControlEphemeral                                                                              $cacheControl
     * @param BetaCitationsConfigParam                                                                               $citations
     * @param null|string                                                                                            $context
     * @param null|string                                                                                            $title
     */
    final public function __construct(
        $source,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $citations = None::NOT_GIVEN,
        $context = None::NOT_GIVEN,
        $title = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRequestDocumentBlock::_loadMetadata();
