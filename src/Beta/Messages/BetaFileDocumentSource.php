<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_file_document_source = array{fileID: string, type: string}
 */
final class BetaFileDocumentSource implements BaseModel
{
    /** @use SdkModel<beta_file_document_source> */
    use SdkModel;

    #[Api]
    public string $type = 'file';

    #[Api('file_id')]
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
