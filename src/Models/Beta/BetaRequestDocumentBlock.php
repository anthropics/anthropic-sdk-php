<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRequestDocumentBlock implements BaseModel
{
    use Model;

    /**
     * @var BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source
     */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public BetaCitationsConfigParam $citations;

    #[Api(optional: true)]
    public ?string $context;

    #[Api(optional: true)]
    public ?string $title;

    /**
     * @param BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource $source
     * @param BetaCacheControlEphemeral                                                                              $cacheControl
     * @param BetaCitationsConfigParam                                                                               $citations
     * @param string|null                                                                                            $context
     * @param string|null                                                                                            $title
     */
    final public function __construct(
        mixed $source,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        BetaCitationsConfigParam|None $citations = None::NOT_SET,
        string|None|null $context = None::NOT_SET,
        string|None|null $title = None::NOT_SET,
    ) {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaRequestDocumentBlock::_loadMetadata();
