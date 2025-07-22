<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A content block that represents a file to be uploaded to the container
 * Files uploaded via this block will be available in the container's input directory.
 *
 * @phpstan-type beta_container_upload_block_param_alias = array{
 *   fileID: string, type: string, cacheControl?: BetaCacheControlEphemeral
 * }
 */
final class BetaContainerUploadBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'container_upload';

    #[Api('file_id')]
    public string $fileID;

    /**
     * Create a cache control breakpoint at this content block.
     */
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
