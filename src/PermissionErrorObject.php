<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PermissionErrorObjectShape = array{
 *   message: string, type: 'permission_error'
 * }
 */
class PermissionErrorObject implements BaseModel
{
    /** @use SdkModel<PermissionErrorObjectShape> */
    use SdkModel;

    /**
     * The broad category of the error.
     *
     * @var 'permission_error' $type
     */
    #[Required(type: new ConstantOf('permission_error'))]
    public string $type = 'permission_error';

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    #[Required]
    public string $message;

    /**
     * `new PermissionErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PermissionErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PermissionErrorObject())->withMessage(...)
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
    public static function with(string $message = 'Permission denied'): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * The broad category of the error.
     *
     * @param 'permission_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(PermissionErrorObject::class, 'Anthropic\PermissionError');
