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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param Base64ImageSource|URLImageSource $source       `required`
     * @param string                           $type         `required`
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
