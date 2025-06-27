<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaImageBlockParam implements BaseModel
{
    use Model;

    /**
     * @var BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source
     */
    #[Api]
    public mixed $source;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @param BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source
     * @param BetaCacheControlEphemeral                                    $cacheControl
     */
    final public function __construct(
        mixed $source,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

BetaImageBlockParam::_loadMetadata();
