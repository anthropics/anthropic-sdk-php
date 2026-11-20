<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Workspace was archived, but External Storage was attached to it during the archive and is still attached. To detach it, archive the Workspace again as a caller with the `org:external-storage:use` permission.
 *
 * @phpstan-type StorageAttachedDuringArchiveErrorDetailsShape = array{
 *   errorCode: 'storage_attached_during_archive'
 * }
 */
final class StorageAttachedDuringArchiveErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageAttachedDuringArchiveErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_attached_during_archive' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('storage_attached_during_archive')
    )]
    public string $errorCode = 'storage_attached_during_archive';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'storage_attached_during_archive' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
