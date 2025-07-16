<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaContentBlockSource\Type;

final class BetaContentBlockSource implements BaseModel
{
    use Model;

    /** @var list<BetaImageBlockParam|BetaTextBlockParam>|string $content */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([BetaTextBlockParam::class, BetaImageBlockParam::class])
                ),
            ],
        ),
    )]
    public array|string $content;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     * @param Type::*                                             $type
     */
    final public function __construct(array|string $content, string $type)
    {
        $this->content = $content;
        $this->type = $type;
    }
}

BetaContentBlockSource::_loadMetadata();
