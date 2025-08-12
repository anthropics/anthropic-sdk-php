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
    public static function from(string $fileID): self
    {
        $obj = new self;

        $obj->fileID = $fileID;

        return $obj;
    }

    public function setFileID(string $fileID): self
    {
        $this->fileID = $fileID;

        return $this;
    }
}
