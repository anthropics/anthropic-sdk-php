<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A content block that represents a file to be uploaded to the container
 * Files uploaded via this block will be available in the container's input directory.
 *
 * @phpstan-type BetaContainerUploadBlockParamShape = array{
 *   file_id: string,
 *   type: 'container_upload',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaContainerUploadBlockParam implements BaseModel
{
    /** @use SdkModel<BetaContainerUploadBlockParamShape> */
    use SdkModel;

    /** @var 'container_upload' $type */
    #[Api]
    public string $type = 'container_upload';

    #[Api]
    public string $file_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaContainerUploadBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainerUploadBlockParam::with(file_id: ...)
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
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     */
    public static function with(
        string $file_id,
        BetaCacheControlEphemeral|array|null $cache_control = null
    ): self {
        $obj = new self;

        $obj['file_id'] = $file_id;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj['file_id'] = $fileID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }
}
