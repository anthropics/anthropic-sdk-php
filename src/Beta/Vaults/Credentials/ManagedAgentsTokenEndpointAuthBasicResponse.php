<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Token endpoint uses HTTP Basic authentication with client credentials.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthBasicResponseShape = array{
 *   type: 'client_secret_basic'
 * }
 */
final class ManagedAgentsTokenEndpointAuthBasicResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthBasicResponseShape> */
    use SdkModel;

    /** @var 'client_secret_basic' $type */
    #[Required(type: new ConstantOf('client_secret_basic'))]
    public string $type = 'client_secret_basic';

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
     * @param 'client_secret_basic' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
