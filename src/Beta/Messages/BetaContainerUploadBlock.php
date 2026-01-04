<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-type BetaContainerUploadBlockShape = array{
 *   fileID: string, type: 'container_upload'
 * }
 */
final class BetaContainerUploadBlock implements BaseModel
{
    /** @use SdkModel<BetaContainerUploadBlockShape> */
    use SdkModel;

    /** @var 'container_upload' $type */
    #[Required]
    public string $type = 'container_upload';

    #[Required('file_id')]
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $fileID): self
    {
        $self = new self;

        $self['fileID'] = $fileID;

        return $self;
    }

    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }
}
