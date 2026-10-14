<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation that a destination was deleted.
 *
 * @phpstan-type DeletedTelemetryDestinationShape = array{
 *   id: string, type: 'telemetry_destination_deleted'
 * }
 */
final class DeletedTelemetryDestination implements BaseModel
{
    /** @use SdkModel<DeletedTelemetryDestinationShape> */
    use SdkModel;

    /** @var 'telemetry_destination_deleted' $type */
    #[Required(type: new ConstantOf('telemetry_destination_deleted'))]
    public string $type = 'telemetry_destination_deleted';

    /**
     * ID of the deleted destination (`tdst_...`).
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedTelemetryDestination()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedTelemetryDestination::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedTelemetryDestination())->withID(...)
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

    /**
     * ID of the deleted destination (`tdst_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'telemetry_destination_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
