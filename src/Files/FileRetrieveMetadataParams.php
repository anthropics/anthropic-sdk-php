<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get File Metadata.
 *
 * @see Anthropic\Services\FilesService::retrieveMetadata()
 *
 * @phpstan-type FileRetrieveMetadataParamsShape = array{workspaceID?: string|null}
 */
final class FileRetrieveMetadataParams implements BaseModel
{
    /** @use SdkModel<FileRetrieveMetadataParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $workspaceID = null): self
    {
        $self = new self;

        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
