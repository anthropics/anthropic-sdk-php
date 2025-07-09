<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class ContentBlockSource implements BaseModel
{
    use Model;

    /** @var list<ImageBlockParam|TextBlockParam>|string $content */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([TextBlockParam::class, ImageBlockParam::class])
                ),
            ],
        ),
    )]
    public mixed $content;

    #[Api]
    public string $type;

    /**
     * @param list<ImageBlockParam|TextBlockParam>|string $content
     * @param string                                      $type
     */
    final public function __construct($content, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

ContentBlockSource::_loadMetadata();
