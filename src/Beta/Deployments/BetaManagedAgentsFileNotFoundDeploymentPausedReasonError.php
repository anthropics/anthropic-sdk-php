<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A file resource referenced by the deployment no longer exists.
 *
 * @phpstan-type BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorShape = array{
 *   type: 'file_not_found_error'
 * }
 */
final class BetaManagedAgentsFileNotFoundDeploymentPausedReasonError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorShape> */
    use SdkModel;

    /** @var 'file_not_found_error' $type */
    #[Required(type: new ConstantOf('file_not_found_error'))]
    public string $type = 'file_not_found_error';

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
     * @param 'file_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
