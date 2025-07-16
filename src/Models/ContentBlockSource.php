<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class ContentBlockSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content';

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
    public array|string $content;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<ImageBlockParam|TextBlockParam>|string $content
     */
    final public function __construct(array|string $content)
    {
        $this->content = $content;
    }
}

ContentBlockSource::__introspect();
