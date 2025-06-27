<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ImageBlockParam implements BaseModel
{
    use Model;

    /**
     * @var Base64ImageSource|URLImageSource $source
     */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public CacheControlEphemeral $cacheControl;

    /**
     * @param Base64ImageSource|URLImageSource $source
     * @param CacheControlEphemeral            $cacheControl
     */
    final public function __construct(
        mixed $source,
        string $type,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

ImageBlockParam::_loadMetadata();
