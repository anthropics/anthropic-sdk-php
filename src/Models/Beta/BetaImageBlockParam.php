<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaImageBlockParam implements BaseModel
{
    use Model;

    /** @var BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @param BetaBase64ImageSource|BetaFileImageSource|BetaURLImageSource $source
     * @param string                                                       $type
     * @param null|BetaCacheControlEphemeral                               $cacheControl
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
