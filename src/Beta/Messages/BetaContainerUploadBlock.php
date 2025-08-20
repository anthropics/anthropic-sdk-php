<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-type beta_container_upload_block_alias = array{
 *   fileID: string, type: string
 * }
 */
final class BetaContainerUploadBlock implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'container_upload';

    #[Api('file_id')]
    public string $fileID;

    /**
     * `new BetaContainerUploadBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainerUploadBlock::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContainerUploadBlock)->withFileID(...)
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
    public static function with(string $fileID): self
    {
        $obj = new self;

        $obj->fileID = $fileID;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj->fileID = $fileID;

        return $obj;
    }
}
