<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-type BetaContainerUploadBlockShape = array{
 *   file_id: string, type: 'container_upload'
 * }
 */
final class BetaContainerUploadBlock implements BaseModel
{
    /** @use SdkModel<BetaContainerUploadBlockShape> */
    use SdkModel;

    /** @var 'container_upload' $type */
    #[Api]
    public string $type = 'container_upload';

    #[Api]
    public string $file_id;

    /**
     * `new BetaContainerUploadBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainerUploadBlock::with(file_id: ...)
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $file_id): self
    {
        $obj = new self;

        $obj['file_id'] = $file_id;

        return $obj;
    }

    public function withFileID(string $fileID): self
    {
        $obj = clone $this;
        $obj['file_id'] = $fileID;

        return $obj;
    }
}
