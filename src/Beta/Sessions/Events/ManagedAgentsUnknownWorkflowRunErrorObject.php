<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A failure that has no type of its own.
 *
 * @phpstan-type ManagedAgentsUnknownWorkflowRunErrorObjectShape = array{
 *   message: string, type: 'unknown_error'
 * }
 */
class ManagedAgentsUnknownWorkflowRunErrorObject implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUnknownWorkflowRunErrorObjectShape> */
    use SdkModel;

    /** @var 'unknown_error' $type */
    #[Required(type: new ConstantOf('unknown_error'))]
    public string $type = 'unknown_error';

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    #[Required]
    public string $message;

    /**
     * `new ManagedAgentsUnknownWorkflowRunErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUnknownWorkflowRunErrorObject::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUnknownWorkflowRunErrorObject())->withMessage(...)
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
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Short explanation written by the server. It never contains content from the run or its agents.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'unknown_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    ManagedAgentsUnknownWorkflowRunErrorObject::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownWorkflowRunError',
);
