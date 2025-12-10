<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A content block that represents a file to be uploaded to the container
 * Files uploaded via this block will be available in the container's input directory.
 *
 * @phpstan-type BetaContainerUploadBlockParamShape = array{
 *   fileID: string,
 *   type?: 'container_upload',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaContainerUploadBlockParam implements BaseModel
{
    /** @use SdkModel<BetaContainerUploadBlockParamShape> */
    use SdkModel;

    /** @var 'container_upload' $type */
    #[Required]
    public string $type = 'container_upload';

    #[Required('file_id')]
    public string $fileID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public static function with(
        string $fileID,
        BetaCacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $obj = new self;

        $obj['fileID'] = $fileID;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj['fileID'] = $fileID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }
}
