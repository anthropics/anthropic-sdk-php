<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaFileDocumentSourceShape = array{fileID: string, type?: 'file'}
 */
final class BetaFileDocumentSource implements BaseModel
{
    /** @use SdkModel<BetaFileDocumentSourceShape> */
    use SdkModel;

    /** @var 'file' $type */
    #[Required]
    public string $type = 'file';

    #[Required('file_id')]
    public string $fileID;

    /**
     * `new BetaFileDocumentSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFileDocumentSource::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFileDocumentSource)->withFileID(...)
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
