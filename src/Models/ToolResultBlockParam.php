<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class ToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public CacheControlEphemeral $cacheControl;

    /**
     * @var list<ImageBlockParam|TextBlockParam>|string $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([TextBlockParam::class, ImageBlockParam::class])
                ),
            ],
        ),
        optional: true,
    )]
    public mixed $content;

    #[Api('is_error', optional: true)]
    public bool $isError;

    /**
     * @param CacheControlEphemeral                       $cacheControl
     * @param list<ImageBlockParam|TextBlockParam>|string $content
     * @param bool                                        $isError
     */
    final public function __construct(
        string $toolUseID,
        string $type,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

ToolResultBlockParam::_loadMetadata();
