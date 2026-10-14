<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The destination covers the workspaces on its list, and no others.
 *
 * @phpstan-type TelemetryDestinationWorkspacesIncludeShape = array{
 *   type: 'include'
 * }
 */
final class TelemetryDestinationWorkspacesInclude implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationWorkspacesIncludeShape> */
    use SdkModel;

    /** @var 'include' $type */
    #[Required(type: new ConstantOf('include'))]
    public string $type = 'include';

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
     * @param 'include' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
