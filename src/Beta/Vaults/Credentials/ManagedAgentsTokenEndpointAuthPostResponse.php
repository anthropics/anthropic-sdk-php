<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Token endpoint uses POST body authentication with client credentials.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthPostResponseShape = array{
 *   type: 'client_secret_post'
 * }
 */
final class ManagedAgentsTokenEndpointAuthPostResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthPostResponseShape> */
    use SdkModel;

    /** @var 'client_secret_post' $type */
    #[Required(type: new ConstantOf('client_secret_post'))]
    public string $type = 'client_secret_post';

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
     * @param 'client_secret_post' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
