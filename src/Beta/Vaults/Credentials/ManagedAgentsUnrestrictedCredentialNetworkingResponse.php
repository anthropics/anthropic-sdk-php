<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The secret is substituted on any host the session's Environment network policy permits egress to.
 *
 * @phpstan-type ManagedAgentsUnrestrictedCredentialNetworkingResponseShape = array{
 *   type: 'unrestricted'
 * }
 */
final class ManagedAgentsUnrestrictedCredentialNetworkingResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUnrestrictedCredentialNetworkingResponseShape> */
    use SdkModel;

    /** @var 'unrestricted' $type */
    #[Required(type: new ConstantOf('unrestricted'))]
    public string $type = 'unrestricted';

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
     * @param 'unrestricted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
