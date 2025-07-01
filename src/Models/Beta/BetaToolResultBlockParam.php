<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @var list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([BetaTextBlockParam::class, BetaImageBlockParam::class])
                ),
            ],
        ),
        optional: true,
    )]
    public mixed $content;

    #[Api('is_error', optional: true)]
    public bool $isError;

    /**
     * @param BetaCacheControlEphemeral                           $cacheControl
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     * @param bool                                                $isError
     */
    final public function __construct(
        string $toolUseID,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        mixed $content = None::NOT_SET,
        bool|None $isError = None::NOT_SET
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

BetaToolResultBlockParam::_loadMetadata();
