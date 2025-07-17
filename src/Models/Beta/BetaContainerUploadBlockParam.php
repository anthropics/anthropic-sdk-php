<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaContainerUploadBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'container_upload';

    #[Api('file_id')]
    public string $fileID;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $fileID,
        ?BetaCacheControlEphemeral $cacheControl = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->fileID = $fileID;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
