<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation of resource deletion.
 *
 * @phpstan-type ManagedAgentsDeleteSessionResourceShape = array{
 *   id: string, type: 'session_resource_deleted'
 * }
 */
final class ManagedAgentsDeleteSessionResource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsDeleteSessionResourceShape> */
    use SdkModel;

    /** @var 'session_resource_deleted' $type */
    #[Required(type: new ConstantOf('session_resource_deleted'))]
    public string $type = 'session_resource_deleted';

    #[Required]
    public string $id;

    /**
     * `new ManagedAgentsDeleteSessionResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsDeleteSessionResource::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsDeleteSessionResource())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'session_resource_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
