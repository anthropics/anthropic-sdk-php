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

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content `required`
     * @param string                                              $type    `required`
     */
    final public function __construct($content, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaContentBlockSource::_loadMetadata();
