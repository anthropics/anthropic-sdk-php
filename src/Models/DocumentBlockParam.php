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
    public CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public CitationsConfigParam $citations;

    #[Api(optional: true)]
    public ?string $context;

    #[Api(optional: true)]
    public ?string $title;

    /**
     * @param Base64PDFSource|ContentBlockSource|PlainTextSource|URLPDFSource $source
     * @param CacheControlEphemeral                                           $cacheControl
     * @param CitationsConfigParam                                            $citations
     * @param null|string                                                     $context
     * @param null|string                                                     $title
     */
    final public function __construct(
        mixed $source,
        string $type,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
        CitationsConfigParam|None $citations = None::NOT_SET,
        null|None|string $context = None::NOT_SET,
        null|None|string $title = None::NOT_SET
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

DocumentBlockParam::_loadMetadata();
