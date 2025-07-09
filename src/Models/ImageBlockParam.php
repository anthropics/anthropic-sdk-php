<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class ImageBlockParam implements BaseModel
{
    use Model;

    /** @var Base64ImageSource|URLImageSource $source */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @param Base64ImageSource|URLImageSource $source
     * @param string                           $type
     * @param null|CacheControlEphemeral       $cacheControl
     */
    final public function __construct(
        $source,
        $type,
        $cacheControl = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

ImageBlockParam::_loadMetadata();
