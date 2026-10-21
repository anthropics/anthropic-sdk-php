<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A memory store referenced by the deployment is archived.
 *
 * @phpstan-type BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorShape = array{
 *   type: 'memory_store_archived_error'
 * }
 */
final class BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError implements BaseModel
{
    /**
     * @use SdkModel<BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorShape>
     */
    use SdkModel;

    /** @var 'memory_store_archived_error' $type */
    #[Required(type: new ConstantOf('memory_store_archived_error'))]
    public string $type = 'memory_store_archived_error';

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
     * @param 'memory_store_archived_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
