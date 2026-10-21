<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A direct caller of the public API, identified by the API key that authenticated the request.
 *
 * @phpstan-type ManagedAgentsAPIActorShape = array{
 *   apiKeyID: string, type: 'api_actor'
 * }
 */
final class ManagedAgentsAPIActor implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAPIActorShape> */
    use SdkModel;

    /** @var 'api_actor' $type */
    #[Required(type: new ConstantOf('api_actor'))]
    public string $type = 'api_actor';

    /**
     * ID of the API key (an `apikey_...` value). This identifies the key, not the secret.
     */
    #[Required('api_key_id')]
    public string $apiKeyID;

    /**
     * `new ManagedAgentsAPIActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAPIActor::with(apiKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAPIActor())->withAPIKeyID(...)
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
    public static function with(string $apiKeyID): self
    {
        $self = new self;

        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * ID of the API key (an `apikey_...` value). This identifies the key, not the secret.
     */
    public function withAPIKeyID(string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * @param 'api_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
