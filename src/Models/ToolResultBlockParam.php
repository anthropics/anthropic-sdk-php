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

    /** @var null|list<ImageBlockParam|TextBlockParam>|string $content */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([TextBlockParam::class, ImageBlockParam::class])
                ),
                'null',
            ],
        ),
        optional: true,
    )]
    public mixed $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * @param string                                           $toolUseID
     * @param string                                           $type
     * @param CacheControlEphemeral                            $cacheControl
     * @param null|list<ImageBlockParam|TextBlockParam>|string $content
     * @param null|bool                                        $isError
     */
    final public function __construct(
        $toolUseID,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $content = None::NOT_GIVEN,
        $isError = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

ToolResultBlockParam::_loadMetadata();
