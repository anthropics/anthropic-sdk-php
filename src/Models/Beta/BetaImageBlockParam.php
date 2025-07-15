<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

final class BetaImageBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source       `required`
     * @param string                                                       $type         `required`
     * @param BetaCacheControlEphemeral                                    $cacheControl
     */
    final public function __construct(
        $source,
        $type,
        $cacheControl = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaImageBlockParam::_loadMetadata();
