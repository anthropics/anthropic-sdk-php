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
     * @param Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source
     * @param string                                                          $type
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
