<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaContainerUploadBlockParam implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @param BetaCacheControlEphemeral $cacheControl
     */
    final public function __construct(
        string $fileID,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET
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

BetaContainerUploadBlockParam::_loadMetadata();
