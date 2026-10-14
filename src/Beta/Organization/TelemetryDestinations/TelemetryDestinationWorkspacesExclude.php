<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The destination covers every workspace of the organization except the workspaces on its list. A workspace created later is covered until it is added to the list.
 *
 * @phpstan-type TelemetryDestinationWorkspacesExcludeShape = array{
 *   type: 'exclude'
 * }
 */
final class TelemetryDestinationWorkspacesExclude implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationWorkspacesExcludeShape> */
    use SdkModel;

    /** @var 'exclude' $type */
    #[Required(type: new ConstantOf('exclude'))]
    public string $type = 'exclude';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'exclude' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
