<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @var string|list<BetaTextBlockParam> $content
     */
    #[Api(
        type: new UnionOf(['string', new ListOf(BetaTextBlockParam::class)]),
        optional: true,
    )]
    public mixed $content;

    #[Api('is_error', optional: true)]
    public bool $isError;

    /**
     * @param BetaCacheControlEphemeral       $cacheControl
     * @param string|list<BetaTextBlockParam> $content
     * @param bool                            $isError
     */
    final public function __construct(
        string $toolUseID,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        mixed $content = None::NOT_SET,
        bool|None $isError = None::NOT_SET,
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

BetaRequestMCPToolResultBlockParam::_loadMetadata();
