<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A memory store referenced by the deployment is archived.
 *
 * @phpstan-type BetaManagedAgentsMemoryStoreArchivedRunErrorShape = array{
 *   message: string, type: 'memory_store_archived_error'
 * }
 */
final class BetaManagedAgentsMemoryStoreArchivedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMemoryStoreArchivedRunErrorShape> */
    use SdkModel;

    /** @var 'memory_store_archived_error' $type */
    #[Required(type: new ConstantOf('memory_store_archived_error'))]
    public string $type = 'memory_store_archived_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsMemoryStoreArchivedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMemoryStoreArchivedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMemoryStoreArchivedRunError())->withMessage(...)
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
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
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
