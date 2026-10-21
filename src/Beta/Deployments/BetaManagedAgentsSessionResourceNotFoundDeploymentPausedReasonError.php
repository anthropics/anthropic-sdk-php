<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A referenced resource no longer exists and its kind was not reported.
 *
 * @phpstan-type BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorShape = array{
 *   type: 'session_resource_not_found_error'
 * }
 */
final class BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'session_resource_not_found_error' $type */
    #[Required(type: new ConstantOf('session_resource_not_found_error'))]
    public string $type = 'session_resource_not_found_error';

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
     * @param 'session_resource_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
