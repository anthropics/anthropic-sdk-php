<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class DocumentBlockParam implements BaseModel
{
    use Model;

    /**
     * @var Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source
     */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?CitationsConfigParam $citations;

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
     * @param Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source       `required`
     * @param string                                                          $type         `required`
     * @param null|CacheControlEphemeral                                      $cacheControl
     * @param null|CitationsConfigParam                                       $citations
     * @param null|string                                                     $context
     * @param null|string                                                     $title
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

DocumentBlockParam::_loadMetadata();
