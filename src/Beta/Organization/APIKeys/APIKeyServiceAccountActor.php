<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyServiceAccountActorShape = array{
 *   serviceAccountID: string, type: 'service_account_actor'
 * }
 */
final class APIKeyServiceAccountActor implements BaseModel
{
    /** @use SdkModel<APIKeyServiceAccountActorShape> */
    use SdkModel;

    /**
     * Principal type. Always `"service_account_actor"` for a Service Account.
     *
     * @var 'service_account_actor' $type
     */
    #[Required]
    public string $type = 'service_account_actor';

    /**
     * ID of the Service Account the API key acts as.
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * `new APIKeyServiceAccountActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyServiceAccountActor::with(serviceAccountID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyServiceAccountActor)->withServiceAccountID(...)
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
     * ID of the Service Account the API key acts as.
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * Principal type. Always `"service_account_actor"` for a Service Account.
     *
     * @param 'service_account_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
