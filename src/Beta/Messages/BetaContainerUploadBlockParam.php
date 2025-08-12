<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        string $fileID,
        ?BetaCacheControlEphemeral $cacheControl = null
    ): self {
        $obj = new self;

        $obj->fileID = $fileID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function setFileID(string $fileID): self
    {
        $this->fileID = $fileID;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
