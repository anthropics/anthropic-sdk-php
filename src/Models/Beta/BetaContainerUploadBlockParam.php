<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaContainerUploadBlockParam\Type;

final class BetaContainerUploadBlockParam implements BaseModel
{
    use Model;

    #[Api('file_id')]
    public string $fileID;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $fileID,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null
    ) {
        $this->fileID = $fileID;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

BetaContainerUploadBlockParam::_loadMetadata();
