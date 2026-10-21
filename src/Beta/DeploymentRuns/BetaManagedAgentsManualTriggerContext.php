<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run was started manually by creating a session directly against the deployment.
 *
 * @phpstan-type BetaManagedAgentsManualTriggerContextShape = array{type: 'manual'}
 */
final class BetaManagedAgentsManualTriggerContext implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsManualTriggerContextShape> */
    use SdkModel;

    /** @var 'manual' $type */
    #[Required(type: new ConstantOf('manual'))]
    public string $type = 'manual';

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
     * @param 'manual' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
