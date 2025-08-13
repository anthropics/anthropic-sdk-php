<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_file_image_source_alias = array{fileID: string, type: string}
 */
final class BetaFileImageSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'file';

    #[Api('file_id')]
    public string $fileID;

    /**
     * `new BetaFileImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFileImageSource::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFileImageSource)->withFileID(...)
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
