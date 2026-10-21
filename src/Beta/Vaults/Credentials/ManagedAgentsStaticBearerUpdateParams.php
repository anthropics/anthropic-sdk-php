<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for updating a static bearer token credential. The `mcp_server_url` is immutable.
 *
 * @phpstan-type ManagedAgentsStaticBearerUpdateParamsShape = array{
 *   type: 'static_bearer', token?: string|null
 * }
 */
final class ManagedAgentsStaticBearerUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerUpdateParamsShape> */
    use SdkModel;

    /** @var 'static_bearer' $type */
    #[Required(type: new ConstantOf('static_bearer'))]
    public string $type = 'static_bearer';

    /**
     * The new static bearer token to replace the stored one.
     */
    #[Optional(nullable: true)]
    public ?string $token;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $token = null): self
    {
        $self = new self;

        null !== $token && $self['token'] = $token;

        return $self;
    }

    /**
     * @param 'static_bearer' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The new static bearer token to replace the stored one.
     */
    public function withToken(?string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }
}
