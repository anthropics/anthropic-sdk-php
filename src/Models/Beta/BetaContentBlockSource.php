<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaContentBlockSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content';

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    final public function __construct(array|string $content)
    {
        $this->content = $content;

        self::_introspect();
    }
}
