<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Attribution for a write made by a workload authenticated as a service account, for example via Workload Identity Federation.
 *
 * @phpstan-type ManagedAgentsServiceAccountActorShape = array{
 *   serviceAccountID: string, type: 'service_account_actor'
 * }
 */
final class ManagedAgentsServiceAccountActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsServiceAccountActorShape> */
    use SdkModel;

    /** @var 'service_account_actor' $type */
    #[Required]
    public string $type = 'service_account_actor';

    /**
     * ID of the service account that performed the write (a `svac_...` value).
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * `new ManagedAgentsServiceAccountActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsServiceAccountActor::with(serviceAccountID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsServiceAccountActor)->withServiceAccountID(...)
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
    public static function with(string $serviceAccountID): self
    {
        $self = new self;

        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * ID of the service account that performed the write (a `svac_...` value).
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * @param 'service_account_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
