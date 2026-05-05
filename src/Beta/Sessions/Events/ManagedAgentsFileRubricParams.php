<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Rubric referenced by a file uploaded via the Files API.
 *
 * @phpstan-type ManagedAgentsFileRubricParamsShape = array{
 *   fileID: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsFileRubricParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsFileRubricParamsShape> */
    use SdkModel;

    /**
     * ID of the rubric file.
     */
    #[Required('file_id')]
    public string $fileID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsFileRubricParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsFileRubricParams::with(fileID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsFileRubricParams)->withFileID(...)->withType(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(string $fileID, Type|string $type): self
    {
        $self = new self;

        $self['fileID'] = $fileID;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
