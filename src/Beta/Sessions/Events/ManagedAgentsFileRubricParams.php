<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Rubric referenced by a file uploaded via the Files API.
 *
 * @phpstan-type ManagedAgentsFileRubricParamsShape = array{
 *   fileID: string, type: 'file'
 * }
 */
final class ManagedAgentsFileRubricParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsFileRubricParamsShape> */
    use SdkModel;

    /** @var 'file' $type */
    #[Required(type: new ConstantOf('file'))]
    public string $type = 'file';

    /**
     * ID of the rubric file.
     */
    #[Required('file_id')]
    public string $fileID;

    /**
     * `new ManagedAgentsFileRubricParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsFileRubricParams::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsFileRubricParams())->withFileID(...)
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

    /**
     * ID of the rubric file.
     */
    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    /**
     * @param 'file' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
