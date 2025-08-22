<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A content block that represents a file to be uploaded to the container
 * Files uploaded via this block will be available in the container's input directory.
 */
final class BetaContainerUploadBlockParam implements BaseModel
{
    use SdkModel;

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
     * `new BetaContainerUploadBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainerUploadBlockParam::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContainerUploadBlockParam)->withFileID(...)
     * ```
     */
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
    public static function with(
        string $fileID,
        ?BetaCacheControlEphemeral $cacheControl = null
    ): self {
        $obj = new self;

        $obj->fileID = $fileID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj->fileID = $fileID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }
}
